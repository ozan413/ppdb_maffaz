<?php

namespace App\Http\Controllers\Santri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\DaftarUlangLilAthfal;
use App\Models\DaftarUlangIddahTahfidz;
use App\Models\DaftarUlangPaudqu;
use Illuminate\Support\Facades\Storage;

class DaftarUlangController extends Controller
{
    /**
     * Show daftar ulang form based on program
     */
    public function index()
    {
        $user = auth()->user();
        $registration = Registration::with(['program', 'graduationDecision'])
            ->where('user_id', $user->id)
            ->first();

        // Check if passed
        if (!$registration || !$registration->graduationDecision || !$registration->graduationDecision->is_lulus) {
            return redirect()->route('santri.dashboard')
                ->with('error', 'Anda belum dinyatakan lulus.');
        }

        $programSlug = strtolower(str_replace([' ', '-'], '_', $registration->program->slug ?? $registration->program->name));
        
        // Check if already submitted
        $existingData = $this->getExistingData($registration->id, $programSlug);
        if ($existingData) {
            return view('santri.daftar-ulang.completed', compact('registration', 'existingData'));
        }

        // Route to appropriate form
        if (str_contains($programSlug, 'lil_athfal') || str_contains($programSlug, 'athfal')) {
            return view('santri.daftar-ulang.lil-athfal', compact('registration'));
        } elseif (str_contains($programSlug, 'iddah') || str_contains($programSlug, 'tahfidz')) {
            return view('santri.daftar-ulang.iddah-tahfidz', compact('registration'));
        } elseif (str_contains($programSlug, 'paud') || str_contains($programSlug, 'paudqu')) {
            return view('santri.daftar-ulang.paudqu', compact('registration'));
        }

        // Default to lil athfal if program not matched
        return view('santri.daftar-ulang.lil-athfal', compact('registration'));
    }

    /**
     * Store Lil Athfal daftar ulang
     */
    public function storeLilAthfal(Request $request)
    {
        $user = auth()->user();
        $registration = Registration::where('user_id', $user->id)->first();

        if (!$registration) {
            return back()->withErrors(['error' => 'Registrasi tidak ditemukan. Silakan daftar terlebih dahulu.'])->withInput();
        }

        $validated = $request->validate([
            'jumlah_saudara' => 'required|integer|min:0|max:15',
            'kondisi_ortu' => 'required|string',
            'nik' => 'required|string|size:16',
            'nisn' => 'required|string|size:10',
            'riwayat_pendidikan_formal' => 'required|string',
            'pas_foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'prestasi' => 'nullable|string',
            'jumlah_hafalan' => 'required|string',
            'pendidikan_ayah' => 'required|string',
            'pendidikan_ibu' => 'required|string',
            'pendidikan_wali' => 'nullable|string',
            'status_rumah' => 'required|string',
            'kondisi_rumah' => 'required|string',
            'perlengkapan_rumah' => 'nullable|array',
        ]);

        // Handle photo upload
        if ($request->hasFile('pas_foto')) {
            $validated['pas_foto'] = $request->file('pas_foto')->store('pas_foto', 'public');
        }

        DaftarUlangLilAthfal::updateOrCreate(
            ['registration_id' => $registration->id],
            $validated
        );

        // Update registration status
        $registration->update(['status' => 're_registered']);

        return redirect()->route('santri.daftar-ulang')
            ->with('success', 'Daftar ulang berhasil disimpan!');
    }

    /**
     * Store Iddah Tahfidz daftar ulang
     */
    public function storeIddahTahfidz(Request $request)
    {
        $user = auth()->user();
        $registration = Registration::where('user_id', $user->id)->first();

        if (!$registration) {
            return back()->withErrors(['error' => 'Registrasi tidak ditemukan. Silakan daftar terlebih dahulu.'])->withInput();
        }

        $validated = $request->validate([
            'jumlah_saudara' => 'required|integer|min:0|max:15',
            'kelas_jenjang_pendidikan' => 'required|string',
            'nik' => 'required|string|size:16',
            'nisn' => 'required|string|size:10',
            'riwayat_pendidikan_formal' => 'required|string',
            'pas_foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'prestasi' => 'nullable|string',
            'pengalaman_menghafal' => 'required|string',
            'jumlah_hafalan_juz' => 'nullable|string',
            'pemahaman_tajwid' => 'required|string',
            'pendidikan_ayah' => 'required|string',
            'pendidikan_ibu' => 'required|string',
            'pendidikan_wali' => 'nullable|string',
            'status_rumah' => 'required|string',
            'kondisi_rumah' => 'required|string',
            'perlengkapan_rumah' => 'nullable|array',
            'pernyataan_data_benar' => 'required|accepted',
            'pernyataan_ikut_aturan' => 'required|accepted',
        ]);

        // Handle photo upload
        if ($request->hasFile('pas_foto')) {
            $validated['pas_foto'] = $request->file('pas_foto')->store('pas_foto', 'public');
        }

        $validated['pernyataan_data_benar'] = true;
        $validated['pernyataan_ikut_aturan'] = true;

        DaftarUlangIddahTahfidz::updateOrCreate(
            ['registration_id' => $registration->id],
            $validated
        );

        // Update registration status
        $registration->update(['status' => 're_registered']);

        return redirect()->route('santri.daftar-ulang')
            ->with('success', 'Daftar ulang berhasil disimpan!');
    }

    /**
     * Store PaudQu daftar ulang
     */
    public function storePaudqu(Request $request)
    {
        $user = auth()->user();
        $registration = Registration::where('user_id', $user->id)->first();

        if (!$registration) {
            return back()->withErrors(['error' => 'Registrasi tidak ditemukan. Silakan daftar terlebih dahulu.'])->withInput();
        }

        $validated = $request->validate([
            'anak_ke' => 'required|integer|min:1|max:15',
            'jumlah_saudara' => 'required|integer|min:0|max:15',
            'nik' => 'required|string|size:16',
            'pendidikan_ayah' => 'required|string',
            'pekerjaan_ayah' => 'required|string',
            'penghasilan_ayah' => 'required|string',
            'pendidikan_ibu' => 'required|string',
            'pekerjaan_ibu' => 'required|string',
            'penghasilan_ibu' => 'required|string',
            'nama_wali' => 'nullable|string',
            'pendidikan_wali' => 'nullable|string',
            'pekerjaan_wali' => 'nullable|string',
            'penghasilan_wali' => 'nullable|string',
            'no_telepon_wali' => 'nullable|string|max:15',
            'alamat_ortu_wali' => 'required|string',
            'pas_foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'pernyataan_data_benar' => 'required|accepted',
            'pernyataan_ikut_aturan' => 'required|accepted',
        ]);

        // Handle photo upload
        if ($request->hasFile('pas_foto')) {
            $validated['pas_foto'] = $request->file('pas_foto')->store('pas_foto', 'public');
        }

        $validated['pernyataan_data_benar'] = true;
        $validated['pernyataan_ikut_aturan'] = true;

        DaftarUlangPaudqu::updateOrCreate(
            ['registration_id' => $registration->id],
            $validated
        );

        // Update registration status
        $registration->update(['status' => 're_registered']);

        return redirect()->route('santri.daftar-ulang')
            ->with('success', 'Daftar ulang berhasil disimpan!');
    }

    /**
     * Get existing daftar ulang data
     */
    private function getExistingData($registrationId, $programSlug)
    {
        if (str_contains($programSlug, 'lil_athfal') || str_contains($programSlug, 'athfal')) {
            return DaftarUlangLilAthfal::where('registration_id', $registrationId)->first();
        } elseif (str_contains($programSlug, 'iddah') || str_contains($programSlug, 'tahfidz')) {
            return DaftarUlangIddahTahfidz::where('registration_id', $registrationId)->first();
        } elseif (str_contains($programSlug, 'paud') || str_contains($programSlug, 'paudqu')) {
            return DaftarUlangPaudqu::where('registration_id', $registrationId)->first();
        }
        return null;
    }
}
