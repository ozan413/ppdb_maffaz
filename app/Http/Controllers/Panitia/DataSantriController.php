<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Program;
use App\Models\DaftarUlangIddahTahfidz;
use App\Models\DaftarUlangLilAthfal;
use App\Models\DaftarUlangPaudqu;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Converter;

class DataSantriController extends Controller
{
    public function index(Request $request)
    {
        $query = Registration::with(['user', 'program', 'graduationDecision'])
            ->where('payment_status', 'paid');

        if ($request->filled('program_id')) {
            $query->where('program_id', $request->program_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $registrations = $query->latest()->paginate(20);
        $programs = Program::all();
        return view('panitia.data-santri.index', compact('registrations', 'programs'));
    }

    public function downloadWord($id)
    {
        $registration = Registration::with(['user', 'program'])->findOrFail($id);
        $programData = $registration->getProgramData();
        $daftarUlang = $this->getDaftarUlangData($registration->id);

        if (!$programData) {
            abort(404, 'Data biodata santri belum tersedia.');
        }

        $phpWord = new PhpWord();
        $phpWord->setDefaultFontName('Arial');
        $phpWord->setDefaultFontSize(9);

        // Header & Footer images
        $headerImg = storage_path('app/templates/header.png');
        $footerImg = storage_path('app/templates/footer.png');

        // Create section with margins
        $section = $phpWord->addSection([
            'marginTop' => Converter::cmToTwip(3.5),
            'marginBottom' => Converter::cmToTwip(2.5),
            'marginLeft' => Converter::cmToTwip(1.5),
            'marginRight' => Converter::cmToTwip(1.5),
        ]);

        // Add Header Image
        if (file_exists($headerImg)) {
            $header = $section->addHeader();
            $header->addImage($headerImg, [
                'width' => 500,
                'positioning' => 'absolute',
                'posHorizontal' => 'center',
                'posHorizontalRel' => 'page',
            ]);
        }

        // Add Footer Image
        if (file_exists($footerImg)) {
            $footer = $section->addFooter();
            $footer->addImage($footerImg, [
                'width' => 500,
                'positioning' => 'absolute',
                'posHorizontal' => 'center',
                'posHorizontalRel' => 'page',
            ]);
        }

        // Warna gold
        $goldBg = 'D4AF37';

        // Title
        $section->addText('FORMULIR PENERIMAAN SANTRI BARU', ['bold' => true, 'size' => 12], ['alignment' => 'center']);
        $section->addText('TAHUN AJARAN 2026', ['bold' => true, 'size' => 11], ['alignment' => 'center']);
        $section->addTextBreak(1);

        // Table style
        $phpWord->addTableStyle('DataTable', ['borderSize' => 4, 'borderColor' => '000000', 'cellMargin' => 50]);

        // ========= PROFIL CALON SANTRI =========
        $headerTbl = $section->addTable(['borderSize' => 0]);
        $headerTbl->addRow();
        $headerTbl->addCell(9500, ['bgColor' => $goldBg])->addText('PROFIL CALON SANTRI', ['bold' => true, 'color' => 'FFFFFF', 'size' => 10]);

        $tbl = $section->addTable('DataTable');
        $this->row($tbl, '1', 'Nama Lengkap', $programData->nama_lengkap ?? '-');
        $this->row($tbl, '2', 'Program', $registration->program->name ?? '-');
        $this->row($tbl, '3', 'Tempat Lahir', $programData->tempat_lahir ?? '-');
        $this->row($tbl, '4', 'Tanggal Lahir', $programData->tanggal_lahir ? date('d-m-Y', strtotime($programData->tanggal_lahir)) : '-');
        $this->row($tbl, '5', 'Usia', $programData->usia ?? '-');
        $this->row($tbl, '6', 'Jenis Kelamin', $programData->gender ?? '-');
        $this->row($tbl, '7', 'Jumlah Saudara', $daftarUlang->jumlah_saudara ?? '-');
        $this->row($tbl, '8', 'Provinsi', $programData->provinsi_domisili ?? '-');
        $this->row($tbl, '9', 'Kota/Kabupaten', $programData->kota_kabupaten ?? '-');
        $this->row($tbl, '10', 'Alamat Lengkap', $programData->domisili_lengkap ?? '-');
        $this->row($tbl, '11', 'NIK', $daftarUlang->nik ?? '-');
        $this->row($tbl, '12', 'NISN', $daftarUlang->nisn ?? '-');
        $this->row($tbl, '13', 'Pendidikan Terakhir', $programData->pendidikan_terakhir ?? '-');
        $this->row($tbl, '14', 'Pendidikan Formal', $programData->riwayat_pendidikan_formal ?? '-');
        $this->row($tbl, '15', 'Pendidikan Non Formal', $programData->riwayat_pendidikan_nonformal ?? '-');
        $this->row($tbl, '16', 'Kelas/Jenjang', $daftarUlang->kelas_jenjang_pendidikan ?? '-');
        $this->row($tbl, '17', 'Ukuran Jubah', $daftarUlang->ukuran_jubah ?? '-');
        $this->row($tbl, '18', 'No HP/WA', $programData->no_hp ?? '-');
        $this->row($tbl, '19', 'Email', $programData->email ?? $registration->user->email ?? '-');
        $this->row($tbl, '20', 'Prestasi', $daftarUlang->prestasi ?? '-');
        $this->row($tbl, '21', 'Pengalaman Menghafal', $daftarUlang->pengalaman_menghafal ?? '-');
        $this->row($tbl, '22', 'Jumlah Hafalan', ($daftarUlang->jumlah_hafalan_juz ?? '-') . ' Juz');
        $this->row($tbl, '23', 'Pemahaman Tajwid', $daftarUlang->pemahaman_tajwid ?? '-');
        $this->row($tbl, '24', 'Sumber Informasi', $programData->sumber_informasi ?? '-');

        $section->addTextBreak(1);

        // ========= DATA ORANGTUA/WALI =========
        $headerTbl2 = $section->addTable(['borderSize' => 0]);
        $headerTbl2->addRow();
        $headerTbl2->addCell(9500, ['bgColor' => $goldBg])->addText('DATA ORANGTUA/WALI', ['bold' => true, 'color' => 'FFFFFF', 'size' => 10]);

        $tbl2 = $section->addTable('DataTable');
        $this->row($tbl2, '25', 'Nama Ayah', $programData->nama_ayah ?? '-');
        $this->row($tbl2, '26', 'Pendidikan Ayah', $daftarUlang->pendidikan_ayah ?? '-');
        $this->row($tbl2, '27', 'Pekerjaan Ayah', $daftarUlang->pekerjaan_ayah ?? '-');
        $this->row($tbl2, '28', 'Penghasilan Ayah', $daftarUlang->penghasilan_ayah ?? '-');
        $this->row($tbl2, '29', 'No Telp Ayah', $daftarUlang->no_telepon_ayah ?? '-');
        $this->row($tbl2, '30', 'Nama Ibu', $programData->nama_ibu ?? '-');
        $this->row($tbl2, '31', 'Pendidikan Ibu', $daftarUlang->pendidikan_ibu ?? '-');
        $this->row($tbl2, '32', 'Pekerjaan Ibu', $daftarUlang->pekerjaan_ibu ?? '-');
        $this->row($tbl2, '33', 'Penghasilan Ibu', $daftarUlang->penghasilan_ibu ?? '-');
        $this->row($tbl2, '34', 'No Telp Ibu', $daftarUlang->no_telepon_ibu ?? '-');
        $this->row($tbl2, '35', 'Nama Wali', $daftarUlang->nama_wali ?? '-');
        $this->row($tbl2, '36', 'Pendidikan Wali', $daftarUlang->pendidikan_wali ?? '-');
        $this->row($tbl2, '37', 'Pekerjaan Wali', $daftarUlang->pekerjaan_wali ?? '-');
        $this->row($tbl2, '38', 'Penghasilan Wali', $daftarUlang->penghasilan_wali ?? '-');
        $this->row($tbl2, '39', 'No Telp Wali', $daftarUlang->no_telepon_wali ?? '-');
        $this->row($tbl2, '40', 'Alamat Ortu/Wali', $daftarUlang->alamat_ortu_wali ?? '-');

        $section->addTextBreak(1);

        // ========= DATA TEMPAT TINGGAL =========
        $headerTbl3 = $section->addTable(['borderSize' => 0]);
        $headerTbl3->addRow();
        $headerTbl3->addCell(9500, ['bgColor' => $goldBg])->addText('DATA TEMPAT TINGGAL', ['bold' => true, 'color' => 'FFFFFF', 'size' => 10]);

        $tbl3 = $section->addTable('DataTable');
        $this->row($tbl3, '41', 'Status Rumah', $daftarUlang->status_rumah ?? '-');
        $this->row($tbl3, '42', 'Kondisi Rumah', $daftarUlang->kondisi_rumah ?? '-');
        $perlengkapan = $daftarUlang->perlengkapan_rumah ?? null;
        $this->row($tbl3, '43', 'Perlengkapan', is_array($perlengkapan) ? implode(', ', $perlengkapan) : ($perlengkapan ?? '-'));

        $section->addTextBreak(1);

        // ========= PERNYATAAN =========
        $headerTbl4 = $section->addTable(['borderSize' => 0]);
        $headerTbl4->addRow();
        $headerTbl4->addCell(9500, ['bgColor' => $goldBg])->addText('PERNYATAAN PENDAFTAR', ['bold' => true, 'color' => 'FFFFFF', 'size' => 10]);

        $section->addText('☑ Saya menyatakan bahwa data yang saya isi adalah benar.', ['size' => 9]);
        $section->addText('☑ Saya bersedia mengikuti aturan program Maskanul Huffadz.', ['size' => 9]);

        $section->addTextBreak(2);

        // ========= TANDA TANGAN =========
        $section->addText('Tangerang Selatan, ' . date('d F Y'), ['size' => 9], ['alignment' => 'right']);
        $section->addTextBreak(2);
        $section->addText($programData->nama_lengkap ?? $registration->user->name, ['bold' => true, 'size' => 9], ['alignment' => 'right']);
        $section->addText('Peserta PSB Maskanul Huffadz', ['size' => 9], ['alignment' => 'right']);

        // Simpan
        $tempDir = storage_path('app/temp');
        if (!file_exists($tempDir)) mkdir($tempDir, 0755, true);

        $santriName = preg_replace('/[^a-zA-Z0-9]/', '_', $programData->nama_lengkap ?? $registration->user->name);
        $filename = "Formulir_{$santriName}.docx";
        $tempPath = $tempDir . '/' . $filename;

        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tempPath);

        return response()->download($tempPath, $filename)->deleteFileAfterSend(true);
    }

    public function downloadTemplate($id)
    {
        $registration = Registration::with([
            'user', 
            'program', 
            'graduationDecision',
            'interviewSchedule',
            'payment'
        ])->findOrFail($id);
        
        $programData = $registration->getProgramData();
        $daftarUlang = $this->getDaftarUlangData($registration->id);

        // Load template
        $templatePath = storage_path('app/templates/Alur PSB I\'dad Tahfidz.docx');
        
        if (!file_exists($templatePath)) {
            abort(404, 'Template file not found');
        }

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);

        // Prepare data array with all possible fields
        $data = [
            // Registration info
            'nama_akun' => $registration->user->name ?? '',
            'email' => $registration->user->email ?? '',
            'program' => $registration->program->name ?? '',
            'tanggal_daftar' => $registration->created_at->format('d F Y'),
            'status_kelulusan' => $this->getStatusKelulusan($registration),
            
            // Program Data (Biodata)
            'nama_lengkap' => $programData->nama_lengkap ?? '',
            'nama_panggilan' => $programData->nama_panggilan ?? '',
            'tempat_lahir' => $programData->tempat_lahir ?? '',
            'tanggal_lahir' => $programData->tanggal_lahir ? date('d F Y', strtotime($programData->tanggal_lahir)) : '',
            'usia' => $programData->usia ?? '',
            'gender' => $programData->gender ?? '',
            'jenis_kelamin' => $programData->gender ?? '',
            'no_hp' => $programData->no_hp ?? '',
            'email_santri' => $programData->email ?? '',
            
            // Alamat
            'provinsi' => $programData->provinsi_domisili ?? '',
            'provinsi_domisili' => $programData->provinsi_domisili ?? '',
            'kota_kabupaten' => $programData->kota_kabupaten ?? '',
            'alamat_lengkap' => $programData->domisili_lengkap ?? '',
            'domisili_lengkap' => $programData->domisili_lengkap ?? '',
            
            // Pendidikan
            'pendidikan_terakhir' => $programData->pendidikan_terakhir ?? '',
            'riwayat_pendidikan_formal' => $programData->riwayat_pendidikan_formal ?? '',
            'riwayat_pendidikan_nonformal' => $programData->riwayat_pendidikan_nonformal ?? '',
            
            // Orang Tua
            'nama_ayah' => $programData->nama_ayah ?? '',
            'pekerjaan_ayah' => $programData->pekerjaan_ayah ?? '',
            'penghasilan_ayah' => $programData->penghasilan_ayah ?? '',
            'nama_ibu' => $programData->nama_ibu ?? '',
            'pekerjaan_ibu' => $programData->pekerjaan_ibu ?? '',
            'penghasilan_ibu' => $programData->penghasilan_ibu ?? '',
            
            // Pengalaman Menghafal (untuk Lil Athfal & Iddah Tahfidz)
            'pengalaman_menghafal' => $programData->pengalaman_menghafal ?? '',
            'jumlah_hafalan' => $programData->jumlah_hafalan ?? '',
            'pemahaman_tajwid' => $programData->pemahaman_tajwid ?? '',
            
            // Program Paudqu
            'program_pilihan' => $programData->program_pilihan ?? '',
            'durasi_program' => $programData->durasi_program ?? '',
            
            // Kesehatan
            'riwayat_sakit' => $programData->riwayat_sakit ?? '',
            'riwayat_kesehatan' => $programData->riwayat_kesehatan ?? '',
            'riwayat_alergi' => $programData->riwayat_alergi ?? '',
            
            // Sumber Informasi
            'sumber_informasi' => $programData->sumber_informasi ?? '',
        ];

        // Daftar Ulang Data (if available)
        if ($daftarUlang) {
            $data = array_merge($data, [
                'nik' => $daftarUlang->nik ?? '',
                'nisn' => $daftarUlang->nisn ?? '',
                'jumlah_saudara' => $daftarUlang->jumlah_saudara ?? '',
                'kelas_jenjang_pendidikan' => $daftarUlang->kelas_jenjang_pendidikan ?? '',
                'ukuran_jubah' => $daftarUlang->ukuran_jubah ?? '',
                'prestasi' => $daftarUlang->prestasi ?? '',
                'jumlah_hafalan_juz' => $daftarUlang->jumlah_hafalan_juz ?? '',
                
                // Orang Tua/Wali Extended
                'pendidikan_ayah' => $daftarUlang->pendidikan_ayah ?? '',
                'no_telepon_ayah' => $daftarUlang->no_telepon_ayah ?? '',
                'pendidikan_ibu' => $daftarUlang->pendidikan_ibu ?? '',
                'no_telepon_ibu' => $daftarUlang->no_telepon_ibu ?? '',
                'nama_wali' => $daftarUlang->nama_wali ?? '',
                'pendidikan_wali' => $daftarUlang->pendidikan_wali ?? '',
                'pekerjaan_wali' => $daftarUlang->pekerjaan_wali ?? '',
                'penghasilan_wali' => $daftarUlang->penghasilan_wali ?? '',
                'no_telepon_wali' => $daftarUlang->no_telepon_wali ?? '',
                'alamat_ortu_wali' => $daftarUlang->alamat_ortu_wali ?? '',
                
                // Tempat Tinggal
                'status_rumah' => $daftarUlang->status_rumah ?? '',
                'kondisi_rumah' => $daftarUlang->kondisi_rumah ?? '',
                'perlengkapan_rumah' => is_array($daftarUlang->perlengkapan_rumah ?? null) 
                    ? implode(', ', $daftarUlang->perlengkapan_rumah) 
                    : ($daftarUlang->perlengkapan_rumah ?? ''),
            ]);
        }

        // Payment info
        if ($registration->payment) {
            $data['status_pembayaran'] = $registration->payment->status ?? '';
            $data['tanggal_pembayaran'] = $registration->payment->created_at->format('d F Y');
        }

        // Interview info
        if ($registration->interviewSchedule) {
            $data['tanggal_wawancara'] = $registration->interviewSchedule->schedule_date 
                ? date('d F Y', strtotime($registration->interviewSchedule->schedule_date)) 
                : '';
            $data['schedule_time'] = $registration->interviewSchedule->schedule_time ?? '';
        }

        // Replace all placeholders
        foreach ($data as $key => $value) {
            try {
                $templateProcessor->setValue($key, $value ?: '-');
            } catch (\Exception $e) {
                // Placeholder not found in template, skip
                continue;
            }
        }

        // Save to temp file
        $tempDir = storage_path('app/temp');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $santriName = preg_replace('/[^a-zA-Z0-9]/', '_', $programData->nama_lengkap ?? $registration->user->name);
        $filename = "Data_Santri_{$santriName}.docx";
        $tempPath = $tempDir . '/' . $filename;

        $templateProcessor->saveAs($tempPath);

        return response()->download($tempPath, $filename)->deleteFileAfterSend(true);
    }

    public function downloadPdfTemplate($id)
    {
        $registration = Registration::with([
            'user', 
            'program', 
            'graduationDecision',
            'payment'
        ])->findOrFail($id);
        
        $programData = $registration->getProgramData();
        $daftarUlang = $this->getDaftarUlangData($registration->id);

        // Prepare all data
        $data = $this->prepareTemplateData($registration, $programData, $daftarUlang);
        
        // Encode foto ke base64 untuk PDF
        $fotoBase64 = null;
        if (!empty($data['pas_foto'])) {
            $fotoPath = storage_path('app/public/' . $data['pas_foto']);
            if (file_exists($fotoPath)) {
                $imageData = file_get_contents($fotoPath);
                $fotoBase64 = 'data:image/' . pathinfo($fotoPath, PATHINFO_EXTENSION) . ';base64,' . base64_encode($imageData);
            }
        }
        
        // Tahun ajaran dinamis
        $currentYear = date('Y');
        $nextYear = $currentYear + 1;
        $tahunAjaran = "$currentYear/$nextYear";
        
        // Generate HTML from view
        $html = view('panitia.data-santri.pdf-generated', [
            'registration' => $registration,
            'programData' => $programData,
            'daftarUlang' => $daftarUlang,
            'data' => $data,
            'fotoBase64' => $fotoBase64,
            'tahunAjaran' => $tahunAjaran
        ])->render();
        
        // Generate PDF menggunakan DomPDF langsung
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        $santriName = preg_replace('/[^a-zA-Z0-9]/', '_', $programData->nama_lengkap ?? $registration->user->name);
        $filename = "Formulir_PSB_{$santriName}.pdf";
        
        return response()->streamDownload(function() use ($dompdf) {
            echo $dompdf->output();
        }, $filename);
    }

    private function prepareTemplateData($registration, $programData, $daftarUlang)
    {
        $data = [
            // Registration info
            'nama_akun' => $registration->user->name ?? '',
            'email' => $registration->user->email ?? '',
            'program' => $registration->program->name ?? '',
            'tanggal_daftar' => $registration->created_at->format('d F Y'),
            'status_kelulusan' => $this->getStatusKelulusan($registration),
            
            // Program Data (Biodata)
            'nama_lengkap' => $programData->nama_lengkap ?? '',
            'nama_panggilan' => $programData->nama_panggilan ?? '',
            'tempat_lahir' => $programData->tempat_lahir ?? '',
            'tanggal_lahir' => $programData->tanggal_lahir ? date('d F Y', strtotime($programData->tanggal_lahir)) : '',
            'usia' => $programData->usia ?? '',
            'gender' => $programData->gender ?? '',
            'no_hp' => $programData->no_hp ?? '',
            'email_santri' => $programData->email ?? '',
            
            // Alamat
            'provinsi' => $programData->provinsi_domisili ?? '',
            'kota_kabupaten' => $programData->kota_kabupaten ?? '',
            'alamat_lengkap' => $programData->domisili_lengkap ?? '',
            
            // Pendidikan
            'pendidikan_terakhir' => $programData->pendidikan_terakhir ?? '',
            'riwayat_pendidikan_formal' => $programData->riwayat_pendidikan_formal ?? '',
            'riwayat_pendidikan_nonformal' => $programData->riwayat_pendidikan_nonformal ?? '',
            
            // Orang Tua
            'nama_ayah' => $programData->nama_ayah ?? '',
            'pekerjaan_ayah' => $programData->pekerjaan_ayah ?? '',
            'penghasilan_ayah' => $programData->penghasilan_ayah ?? '',
            'nama_ibu' => $programData->nama_ibu ?? '',
            'pekerjaan_ibu' => $programData->pekerjaan_ibu ?? '',
            'penghasilan_ibu' => $programData->penghasilan_ibu ?? '',
            
            // Pengalaman Menghafal (untuk Lil Athfal & Iddah Tahfidz)
            'pengalaman_menghafal' => $programData->pengalaman_menghafal ?? '',
            'jumlah_hafalan' => $programData->jumlah_hafalan ?? '',
            'pemahaman_tajwid' => $programData->pemahaman_tajwid ?? '',
            
            // Program Paudqu
            'program_pilihan' => $programData->program_pilihan ?? '',
            'durasi_program' => $programData->durasi_program ?? '',
            
            // Kesehatan
            'riwayat_sakit' => $programData->riwayat_sakit ?? '',
            'riwayat_kesehatan' => $programData->riwayat_kesehatan ?? '',
            'riwayat_alergi' => $programData->riwayat_alergi ?? '',
            
            // Sumber Informasi
            'sumber_informasi' => $programData->sumber_informasi ?? '',
            
            // Pas Foto
            'pas_foto' => $programData->pas_foto ?? '',
        ];

        // Daftar Ulang Data
        if ($daftarUlang) {
            $data = array_merge($data, [
                'nik' => $daftarUlang->nik ?? '',
                'nisn' => $daftarUlang->nisn ?? '',
                'jumlah_saudara' => $daftarUlang->jumlah_saudara ?? '',
                'kelas_jenjang_pendidikan' => $daftarUlang->kelas_jenjang_pendidikan ?? '',
                'ukuran_jubah' => $daftarUlang->ukuran_jubah ?? '',
                'prestasi' => $daftarUlang->prestasi ?? '',
                'jumlah_hafalan_juz' => $daftarUlang->jumlah_hafalan_juz ?? '',
                
                // Orang Tua/Wali Extended
                'pendidikan_ayah' => $daftarUlang->pendidikan_ayah ?? '',
                'no_telepon_ayah' => $daftarUlang->no_telepon_ayah ?? '',
                'pendidikan_ibu' => $daftarUlang->pendidikan_ibu ?? '',
                'no_telepon_ibu' => $daftarUlang->no_telepon_ibu ?? '',
                'nama_wali' => $daftarUlang->nama_wali ?? '',
                'pendidikan_wali' => $daftarUlang->pendidikan_wali ?? '',
                'pekerjaan_wali' => $daftarUlang->pekerjaan_wali ?? '',
                'penghasilan_wali' => $daftarUlang->penghasilan_wali ?? '',
                'no_telepon_wali' => $daftarUlang->no_telepon_wali ?? '',
                'alamat_ortu_wali' => $daftarUlang->alamat_ortu_wali ?? '',
                
                // Tempat Tinggal
                'status_rumah' => $daftarUlang->status_rumah ?? '',
                'kondisi_rumah' => $daftarUlang->kondisi_rumah ?? '',
                'perlengkapan_rumah' => is_array($daftarUlang->perlengkapan_rumah ?? null) 
                    ? implode(', ', $daftarUlang->perlengkapan_rumah) 
                    : ($daftarUlang->perlengkapan_rumah ?? ''),
            ]);
        }

        // Payment info
        if ($registration->payment) {
            $data['status_pembayaran'] = $registration->payment->status ?? '';
            $data['tanggal_pembayaran'] = $registration->payment->created_at->format('d F Y');
            $data['jumlah_pembayaran'] = 'Rp ' . number_format($registration->payment->amount ?? 0, 0, ',', '.');
        }

        // Interview info - Commented out karena relasi belum ada
        // if ($registration->interview) {
        //     $data['tanggal_wawancara'] = $registration->interview->scheduled_at 
        //         ? date('d F Y H:i', strtotime($registration->interview->scheduled_at)) 
        //         : '';
        //     $data['nilai_wawancara'] = $registration->interview->score ?? '';
        //     $data['catatan_wawancara'] = $registration->interview->notes ?? '';
        // }

        return $data;
    }

    private function getStatusKelulusan($registration)
    {
        if ($registration->graduationDecision && $registration->graduationDecision->is_lulus) {
            return 'LULUS';
        } elseif ($registration->graduationDecision && !$registration->graduationDecision->is_lulus) {
            return 'TIDAK LULUS';
        } else {
            return 'MENUNGGU';
        }
    }

    private function row($table, $no, $label, $value)
    {
        $row = $table->addRow();
        $row->addCell(500)->addText($no, ['size' => 9], ['alignment' => 'center']);
        $row->addCell(3500)->addText($label, ['size' => 9]);
        $row->addCell(5500)->addText($value, ['bold' => true, 'size' => 9]);
    }

    private function getDaftarUlangData($registrationId)
    {
        $data = DaftarUlangIddahTahfidz::where('registration_id', $registrationId)->first();
        if (!$data) $data = DaftarUlangLilAthfal::where('registration_id', $registrationId)->first();
        if (!$data) $data = DaftarUlangPaudqu::where('registration_id', $registrationId)->first();
        return $data;
    }
}
