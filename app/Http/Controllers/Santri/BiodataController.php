<?php

namespace App\Http\Controllers\Santri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\DataLilAthfal;
use App\Models\DataIddahTahfidz;
use App\Models\DataPaudqu;
use Illuminate\Support\Facades\Storage;

class BiodataController extends Controller
{
    /**
     * Show biodata page
     */
    public function index()
    {
        $user = auth()->user();
        $registration = Registration::with('program')
            ->where('user_id', $user->id)
            ->first();

        // If no registration at all, redirect to program selection
        if (!$registration) {
            return redirect()->route('santri.program.index')
                ->with('info', 'Silakan pilih program terlebih dahulu.');
        }

        // Get program data (may be null if not filled yet)
        $data = $registration->getProgramData();
        $canEdit = $registration->payment_status !== 'paid';

        return view('santri.biodata', compact('registration', 'data', 'canEdit'));
    }

    /**
     * Update biodata
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        $registration = Registration::with('program')
            ->where('user_id', $user->id)
            ->first();

        if (!$registration) {
            return redirect()->route('santri.program.index')
                ->withErrors(['error' => 'Registrasi tidak ditemukan.']);
        }

        // Check if payment is already made
        if ($registration->payment_status === 'paid') {
            return back()->withErrors(['error' => 'Data tidak dapat diubah setelah pembayaran.']);
        }

        $programSlug = $registration->program->slug;

        try {
            switch ($programSlug) {
                case 'lil-athfal':
                    $this->updateLilAthfal($request, $registration);
                    break;
                case 'iddah-tahfidz':
                    $this->updateIddahTahfidz($request, $registration);
                    break;
                case 'paudqu':
                    $this->updatePaudqu($request, $registration);
                    break;
            }

            return redirect()->route('santri.biodata.index')
                ->with('success', 'Data berhasil diperbarui!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e; // Let Laravel handle validation errors natively with proper $errors bag
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    protected function updateLilAthfal(Request $request, Registration $registration)
    {
        $validated = $request->validate([
            'program_pilihan' => 'required|in:Lil Athfal Reguler,Lil Athfal Beasiswa',
            'jalur_masuk_program' => 'nullable|in:Reguler,Beasiswa',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'usia' => 'required|integer|min:1',
            'gender' => 'required|in:Laki-Laki,Perempuan',
            'pendidikan_terakhir' => 'required|string|max:255',
            'riwayat_pendidikan_nonformal' => 'nullable|string',
            'provinsi_domisili' => 'required|string|max:255',
            'kota_kabupaten' => 'required|string|max:255',
            'domisili_lengkap' => 'required|string',
            'pemahaman_tajwid' => 'required|string|max:255',
            'sumber_informasi' => 'nullable|string|max:255',
            'nama_ayah' => 'required|string|max:255',
            'pekerjaan_ayah' => 'required|string|max:255',
            'penghasilan_ayah' => 'required|string|max:255',
            'no_telepon_ayah' => 'nullable|string|max:20',
            'nama_ibu' => 'required|string|max:255',
            'pekerjaan_ibu' => 'required|string|max:255',
            'penghasilan_ibu' => 'required|string|max:255',
            'no_telepon_ibu' => 'nullable|string|max:20',
            'nama_wali' => 'nullable|string|max:255',
            'no_telepon_wali' => 'nullable|string|max:20',
            'pekerjaan_wali' => 'nullable|string|max:255',
            'penghasilan_wali' => 'nullable|string|max:255',
            'alamat_ortu_wali' => 'nullable|string',
        ]);

        $data = DataLilAthfal::where('registration_id', $registration->id)->first();

        if (!$data) {
            throw new \Exception('Data biodata Lil Athfal belum tersedia.');
        }

        $data->update($validated);
    }

    protected function updateIddahTahfidz(Request $request, Registration $registration)
    {
        $validated = $request->validate([
            'jalur_program' => 'nullable|string|max:255',
            'jalur_masuk_program' => 'nullable|in:Reguler,Beasiswa',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'usia' => 'required|integer|min:1',
            'gender' => 'required|in:Laki-Laki,Perempuan',
            'pendidikan_terakhir' => 'required|string|max:255',
            'riwayat_pendidikan_nonformal' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'provinsi_domisili' => 'required|string|max:255',
            'kota_kabupaten' => 'required|string|max:255',
            'domisili_lengkap' => 'required|string',
            'sumber_informasi' => 'nullable|string|max:255',
            'nama_ayah' => 'required|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:255',
            'penghasilan_ayah' => 'nullable|string|max:255',
            'no_telepon_ayah' => 'nullable|string|max:20',
            'nama_ibu' => 'required|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:255',
            'penghasilan_ibu' => 'nullable|string|max:255',
            'no_telepon_ibu' => 'nullable|string|max:20',
            'nama_wali' => 'nullable|string|max:255',
            'pekerjaan_wali' => 'nullable|string|max:255',
            'penghasilan_wali' => 'nullable|string|max:255',
            'no_telepon_wali' => 'nullable|string|max:20',
        ]);

        $data = DataIddahTahfidz::where('registration_id', $registration->id)->first();

        if (!$data) {
            throw new \Exception('Data biodata Iddah Tahfidz belum tersedia.');
        }

        $data->update($validated);
    }

    protected function updatePaudqu(Request $request, Registration $registration)
    {
        $validated = $request->validate([
            'program_pilihan' => 'required|in:PaudQu Reguler,PaudQu Fullday',
            'durasi_program' => 'required|in:1 Tahun,2 Tahun',
            'jalur_masuk_program' => 'nullable|in:Reguler,Beasiswa',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'usia' => 'required|integer|min:1',
            'gender' => 'required|in:Laki-Laki,Perempuan',
            'email' => 'nullable|email|max:255',
            'provinsi_domisili' => 'required|string|max:255',
            'kota_kabupaten' => 'required|string|max:255',
            'domisili_lengkap' => 'required|string',
            'sumber_informasi' => 'nullable|string|max:255',
            'nama_ayah' => 'required|string|max:255',
            'no_telepon_ayah' => 'nullable|string|max:20',
            'nama_ibu' => 'required|string|max:255',
            'no_telepon_ibu' => 'nullable|string|max:20',
        ]);

        $data = DataPaudqu::where('registration_id', $registration->id)->first();

        if (!$data) {
            throw new \Exception('Data biodata PaudQu belum tersedia.');
        }

        $data->update($validated);
    }
}
