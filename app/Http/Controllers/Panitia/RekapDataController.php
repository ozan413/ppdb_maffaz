<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\GraduationDecision;
use App\Models\DataLilAthfal;
use App\Models\DataIddahTahfidz;
use App\Models\DataPaudqu;
use App\Models\DaftarUlangLilAthfal;
use App\Models\DaftarUlangIddahTahfidz;
use App\Models\DaftarUlangPaudqu;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RekapDataController extends Controller
{
    /**
     * Display rekap data for graduated students
     */
    public function index(Request $request)
    {
        $query = Registration::with([
            'user',
            'program',
            'payment',
            'graduationDecision',
            'interviewSchedule.result.aspectScores.aspect'
        ])->whereHas('graduationDecision');

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'lulus') {
                $query->whereHas('graduationDecision', fn($q) => $q->where('is_lulus', true));
            } else {
                $query->whereHas('graduationDecision', fn($q) => $q->where('is_lulus', false));
            }
        }

        // Filter by program
        if ($request->filled('program_id')) {
            $query->where('program_id', $request->program_id);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%{$search}%"));
        }

        $registrations = $query->latest()->paginate(20);
        $programs = \App\Models\Program::all();

        // Stats
        $stats = [
            'total' => Registration::whereHas('graduationDecision')->count(),
            'lulus' => GraduationDecision::where('is_lulus', true)->count(),
            'tidak_lulus' => GraduationDecision::where('is_lulus', false)->count(),
        ];

        // Prepare full data for each registration
        foreach ($registrations as $reg) {
            $reg->programData = $reg->getProgramData();
            $reg->daftarUlangData = $this->getDaftarUlangData($reg->id);
        }

        return view('panitia.rekap-data.index', compact('registrations', 'programs', 'stats'));
    }

    /**
     * Export to Google Spreadsheet (returns TSV data for clipboard)
     */
    public function exportExcel(Request $request)
    {
        $query = Registration::with([
            'user',
            'program',
            'payment',
            'graduationDecision',
            'interviewSchedule.result.aspectScores.aspect'
        ])->whereHas('graduationDecision');

        // Apply same filters
        if ($request->filled('status')) {
            if ($request->status === 'lulus') {
                $query->whereHas('graduationDecision', fn($q) => $q->where('is_lulus', true));
            } else {
                $query->whereHas('graduationDecision', fn($q) => $q->where('is_lulus', false));
            }
        }

        if ($request->filled('program_id')) {
            $query->where('program_id', $request->program_id);
        }

        $registrations = $query->get();

        // Build TSV data (Tab-separated for easy paste to Google Sheets)
        $rows = [];
        
        // Header row
        $rows[] = [
            'NO',
            'NAMA AKUN',
            'EMAIL',
            'PROGRAM',
            'STATUS KELULUSAN',
            'CATATAN PANITIA',
            'NAMA LENGKAP',
            'TEMPAT LAHIR',
            'TANGGAL LAHIR',
            'USIA',
            'JENIS KELAMIN',
            'NO HP',
            'PROVINSI',
            'KOTA/KAB',
            'ALAMAT LENGKAP',
            'NAMA AYAH',
            'PEKERJAAN AYAH',
            'NAMA IBU',
            'PEKERJAAN IBU',
            'NILAI TAHFIDZ',
            'NILAI TAHSIN',
            'NILAI B. ARAB',
            'NILAI TAJWID',
            'RATA-RATA AKADEMIK',
            'CATATAN USTAD',
            'STATUS BAYAR',
            'JUMLAH BAYAR',
            'TANGGAL BAYAR',
            'NIK',
            'NISN',
            'UKURAN JUBAH',
        ];

        $no = 1;
        foreach ($registrations as $reg) {
            $programData = $reg->getProgramData();
            $daftarUlang = $this->getDaftarUlangData($reg->id);
            $result = $reg->interviewSchedule?->result;

            // Calculate academic average
            $avgAcademic = 0;
            if ($result) {
                $nilaiTahfidz = $result->nilai_tahfidz ?? 0;
                $nilaiTahsin = $result->nilai_tahsin ?? 0;
                $nilaiBArab = $result->nilai_bahasa_arab ?? 0;
                $nilaiTajwid = $result->nilai_tajwid ?? 0;
                $avgAcademic = ($nilaiTahfidz + $nilaiTahsin + $nilaiBArab + $nilaiTajwid) / 4;
            }

            $rows[] = [
                $no++,
                $reg->user->name ?? '-',
                $reg->user->email ?? '-',
                $reg->program->name ?? '-',
                $reg->graduationDecision?->is_lulus ? 'LULUS' : 'TIDAK LULUS',
                $reg->graduationDecision?->notes ?? '-',
                $programData->nama_lengkap ?? '-',
                $programData->tempat_lahir ?? '-',
                $programData->tanggal_lahir ?? '-',
                $programData->usia ?? '-',
                $programData->gender ?? '-',
                $programData->no_hp ?? '-',
                $programData->provinsi_domisili ?? '-',
                $programData->kota_kabupaten ?? '-',
                $programData->domisili_lengkap ?? '-',
                $programData->nama_ayah ?? '-',
                $programData->pekerjaan_ayah ?? '-',
                $programData->nama_ibu ?? '-',
                $programData->pekerjaan_ibu ?? '-',
                $result->nilai_tahfidz ?? '-',
                $result->nilai_tahsin ?? '-',
                $result->nilai_bahasa_arab ?? '-',
                $result->nilai_tajwid ?? '-',
                $result ? number_format($avgAcademic, 2) : '-',
                $result->catatan_ustad ?? '-',
                $reg->payment_status === 'paid' ? 'LUNAS' : 'BELUM BAYAR',
                $reg->payment ? number_format($reg->payment->amount, 0, ',', '.') : '-',
                $reg->payment?->paid_at ? date('d/m/Y H:i', strtotime($reg->payment->paid_at)) : '-',
                $daftarUlang->nik ?? '-',
                $daftarUlang->nisn ?? '-',
                $daftarUlang->ukuran_jubah ?? '-',
            ];
        }

        // Convert to TSV string
        $tsvData = '';
        foreach ($rows as $row) {
            $tsvData .= implode("\t", $row) . "\n";
        }

        return response()->json([
            'success' => true,
            'data' => $tsvData,
            'total' => count($registrations),
            'date' => date('d F Y H:i'),
        ]);
    }

    /**
     * Get daftar ulang data for a registration
     */
    private function getDaftarUlangData($registrationId)
    {
        $data = DaftarUlangLilAthfal::where('registration_id', $registrationId)->first();
        if (!$data) {
            $data = DaftarUlangIddahTahfidz::where('registration_id', $registrationId)->first();
        }
        if (!$data) {
            $data = DaftarUlangPaudqu::where('registration_id', $registrationId)->first();
        }
        return $data;
    }
}
