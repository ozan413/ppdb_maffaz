<?php

namespace App\Http\Controllers\Santri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Registration;
use App\Models\DataLilAthfal;
use App\Models\DataIddahTahfidz;
use App\Models\DataPaudqu;
use App\Models\HomepageSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProgramController extends Controller
{
    /**
     * Show program selection page
     */
    public function index()
    {
        $user = auth()->user();
        $registration = Registration::with(['program', 'payment'])->where('user_id', $user->id)->first();

        // If already registered and program locked
        if ($registration && $registration->is_program_locked) {
            // If already paid, show payment completed status
            if ($registration->payment_status === 'paid') {
                return view('santri.program.completed', compact('registration'));
            }
            // If not yet paid, redirect to payment
            return redirect()->route('santri.payment.index');
        }

        // Check if PPDB is open
        if (!HomepageSetting::isPPDBOpen() && !$registration) {
            return redirect()->route('santri.dashboard')
                ->with('error', 'Pendaftaran PPDB belum dibuka.');
        }

        $programs = Program::active()->get();
        return view('santri.program.index', compact('programs', 'registration'));
    }

    /**
     * Select a program
     */
    public function selectProgram(Request $request)
    {
        $request->validate([
            'program_id' => 'required|exists:programs,id',
        ]);

        $user = auth()->user();
        $program = Program::findOrFail($request->program_id);

        // Check if user already has a registration
        $registration = Registration::where('user_id', $user->id)->first();

        if ($registration && $registration->is_program_locked) {
            return back()->withErrors(['error' => 'Program sudah dikunci dan tidak dapat diubah.']);
        }

        if ($registration) {
            $registration->update(['program_id' => $program->id]);
        } else {
            $registration = Registration::create([
                'user_id' => $user->id,
                'program_id' => $program->id,
                'status' => 'draft',
                'payment_status' => 'pending',
                'is_program_locked' => false,
            ]);
        }

        return redirect()->route('santri.program.form', $program->slug);
    }

    /**
     * Show program-specific form
     */
    public function showForm($slug)
    {
        $user = auth()->user();
        $program = Program::where('slug', $slug)->firstOrFail();
        $registration = Registration::where('user_id', $user->id)
            ->where('program_id', $program->id)
            ->first();

        if (!$registration) {
            return redirect()->route('santri.program.index')
                ->with('error', 'Silakan pilih program terlebih dahulu.');
        }

        if ($registration->payment_status === 'paid') {
            return redirect()->route('santri.biodata.index')
                ->with('info', 'Data tidak dapat diubah setelah pembayaran.');
        }

        // Get existing data if any
        $data = $registration->getProgramData();

        $viewName = match($slug) {
            'lil-athfal' => 'santri.program.lil-athfal',
            'iddah-tahfidz' => 'santri.program.iddah-tahfidz',
            'paudqu' => 'santri.program.paudqu',
            default => abort(404),
        };

        return view($viewName, compact('program', 'registration', 'data'));
    }

    /**
     * Store program-specific form data
     */
    public function storeForm(Request $request, $slug)
    {
        $user = auth()->user();
        $program = Program::where('slug', $slug)->firstOrFail();
        $registration = Registration::where('user_id', $user->id)
            ->where('program_id', $program->id)
            ->first();

        if (!$registration) {
            return redirect()->route('santri.program.index')
                ->withErrors(['error' => 'Registrasi tidak ditemukan.']);
        }

        if ($registration->payment_status === 'paid') {
            return redirect()->route('santri.biodata.index')
                ->with('error', 'Data tidak dapat diubah setelah pembayaran.');
        }

        DB::beginTransaction();

        try {
            // Validate and store based on program type
            switch ($slug) {
                case 'lil-athfal':
                    $this->storeLilAthfal($request, $registration, $program);
                    break;
                case 'iddah-tahfidz':
                    $this->storeIddahTahfidz($request, $registration, $program);
                    break;
                case 'paudqu':
                    $this->storePaudqu($request, $registration, $program);
                    break;
                default:
                    throw new \Exception('Program tidak valid.');
            }

            // Lock the program and update status
            $registration->update([
                'is_program_locked' => true,
                'status' => 'submitted',
            ]);

            DB::commit();

            return redirect()->route('santri.payment.index')
                ->with('success', 'Data pendaftaran berhasil disimpan! Silakan lanjutkan ke pembayaran.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            throw $e; // Let Laravel handle validation errors natively with proper $errors bag
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Store Lil Athfal data
     */
    protected function storeLilAthfal(Request $request, Registration $registration, Program $program)
    {
        $validated = $request->validate([
            'program_pilihan' => 'required|in:Lil Athfal Reguler,Lil Athfal Beasiswa',
            'jalur_masuk_program' => 'required|in:Reguler,Beasiswa',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'usia' => 'required|string|max:50',
            'gender' => 'required|in:Laki-Laki,Perempuan',
            'pendidikan_terakhir' => 'required|string|max:255',
            'riwayat_pendidikan_nonformal' => 'nullable|string',
            'provinsi_domisili' => 'required|string|max:255',
            'kota_kabupaten' => 'required|string|max:255',
            'domisili_lengkap' => 'required|string',
            'pemahaman_tajwid' => 'required|string|max:255',
            'sumber_informasi' => 'required|string|max:255',
            'nama_ayah' => 'required|string|max:255',
            'no_telepon_ayah' => 'required|string|max:20',
            'pekerjaan_ayah' => 'required|string|max:255',
            'penghasilan_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'no_telepon_ibu' => 'required|string|max:20',
            'pekerjaan_ibu' => 'required|string|max:255',
            'penghasilan_ibu' => 'required|string|max:255',
            'nama_wali' => 'nullable|string|max:255',
            'no_telepon_wali' => 'nullable|string|max:20',
            'pekerjaan_wali' => 'nullable|string|max:255',
            'penghasilan_wali' => 'nullable|string|max:255',
            'alamat_ortu_wali' => 'required|string',
        ]);

        $validated['registration_id'] = $registration->id;
        $validated['program_id'] = $program->id;

        DataLilAthfal::updateOrCreate(
            ['registration_id' => $registration->id],
            $validated
        );
    }

    /**
     * Store Iddah Tahfidz data
     */
    protected function storeIddahTahfidz(Request $request, Registration $registration, Program $program)
    {
        $validated = $request->validate([
            'jalur_program' => 'required|string|max:255',
            'jalur_masuk_program' => 'required|in:Reguler,Beasiswa',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'usia' => 'required|string|max:50',
            'gender' => 'required|in:Laki-Laki,Perempuan',
            'pendidikan_terakhir' => 'required|string|max:255',
            'riwayat_pendidikan_nonformal' => 'nullable|string',
            'no_hp' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'provinsi_domisili' => 'required|string|max:255',
            'kota_kabupaten' => 'required|string|max:255',
            'domisili_lengkap' => 'required|string',
            'sumber_informasi' => 'required|string|max:255',
            'nama_ayah' => 'required|string|max:255',
            'no_telepon_ayah' => 'required|string|max:20',
            'pekerjaan_ayah' => 'required|string|max:255',
            'penghasilan_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'no_telepon_ibu' => 'required|string|max:20',
            'pekerjaan_ibu' => 'required|string|max:255',
            'penghasilan_ibu' => 'required|string|max:255',
            'nama_wali' => 'nullable|string|max:255',
            'no_telepon_wali' => 'nullable|string|max:20',
            'pekerjaan_wali' => 'nullable|string|max:255',
            'penghasilan_wali' => 'nullable|string|max:255',
        ]);

        $validated['registration_id'] = $registration->id;
        $validated['program_id'] = $program->id;

        DataIddahTahfidz::updateOrCreate(
            ['registration_id' => $registration->id],
            $validated
        );
    }

    /**
     * Store PaudQu data
     */
    protected function storePaudqu(Request $request, Registration $registration, Program $program)
    {
        $validated = $request->validate([
            'program_pilihan' => 'required|in:PaudQu Reguler,PaudQu Fullday',
            'jalur_masuk_program' => 'required|in:Reguler,Beasiswa',
            'durasi_program' => 'required|in:1 Tahun,2 Tahun',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'usia' => 'required|string|max:50',
            'gender' => 'required|in:Laki-Laki,Perempuan',
            'email' => 'required|email|max:255',
            'provinsi_domisili' => 'required|string|max:255',
            'kota_kabupaten' => 'required|string|max:255',
            'domisili_lengkap' => 'required|string',
            'sumber_informasi' => 'required|string|max:255',
            'nama_ayah' => 'required|string|max:255',
            'no_telepon_ayah' => 'required|string|max:20',
            'nama_ibu' => 'required|string|max:255',
            'no_telepon_ibu' => 'required|string|max:20',
        ]);

        $validated['registration_id'] = $registration->id;
        $validated['program_id'] = $program->id;

        DataPaudqu::updateOrCreate(
            ['registration_id' => $registration->id],
            $validated
        );
    }
}
