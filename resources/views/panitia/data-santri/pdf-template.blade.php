<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Formulir PSB - {{ $programData->nama_lengkap ?? $registration->user->name }}</title>
    <style>
        @page {
            margin: 1.5cm;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #1a5f2a;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 14pt;
            color: #1a5f2a;
        }
        .header h2 {
            margin: 5px 0 0;
            font-size: 12pt;
            font-weight: normal;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 10pt;
            color: #666;
        }
        .section-title {
            background: #1a5f2a;
            color: white;
            padding: 8px 15px;
            font-weight: bold;
            margin: 20px 0 10px;
            font-size: 11pt;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table.data-table td {
            padding: 6px 10px;
            border: 1px solid #ddd;
            vertical-align: top;
        }
        table.data-table td.no {
            width: 30px;
            text-align: center;
            background: #f5f5f5;
        }
        table.data-table td.label {
            width: 200px;
            background: #f9f9f9;
        }
        table.data-table td.colon {
            width: 15px;
            text-align: center;
        }
        table.data-table td.value {
            font-weight: 500;
        }
        .photo-box {
            float: right;
            width: 3cm;
            height: 4cm;
            border: 1px solid #333;
            text-align: center;
            line-height: 4cm;
            font-size: 9pt;
            color: #999;
            margin-left: 15px;
            margin-bottom: 10px;
        }
        .signature-section {
            margin-top: 40px;
            page-break-inside: avoid;
        }
        .signature-box {
            text-align: center;
            width: 250px;
            margin-left: auto;
        }
        .signature-box .date {
            margin-bottom: 60px;
        }
        .signature-box .name {
            border-top: 1px solid #333;
            padding-top: 5px;
        }
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>FORMULIR PENERIMAAN SANTRI BARU</h1>
        <h2>PESANTREN TAHFIDZ MASKANUL HUFFADZ</h2>
        <p>TAHUN AJARAN 2026</p>
    </div>

    <div class="clearfix">
        <div class="photo-box">
            @if($programData && $programData->pas_foto)
                <img src="{{ storage_path('app/public/' . $programData->pas_foto) }}" style="width: 100%; height: 100%; object-fit: cover;">
            @else
                Pas Foto<br>3x4
            @endif
        </div>

        <div class="section-title">PROFIL CALON SANTRI</div>
    </div>

    <table class="data-table">
        <tr>
            <td class="no">1</td>
            <td class="label">Nama Lengkap</td>
            <td class="colon">:</td>
            <td class="value">{{ $programData->nama_lengkap ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">2</td>
            <td class="label">Pilihan Program</td>
            <td class="colon">:</td>
            <td class="value">{{ $registration->program->name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">3</td>
            <td class="label">Tempat Lahir</td>
            <td class="colon">:</td>
            <td class="value">{{ $programData->tempat_lahir ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">4</td>
            <td class="label">Tanggal Lahir</td>
            <td class="colon">:</td>
            <td class="value">{{ $programData->tanggal_lahir ? date('d-m-Y', strtotime($programData->tanggal_lahir)) : '-' }}</td>
        </tr>
        <tr>
            <td class="no">5</td>
            <td class="label">Usia</td>
            <td class="colon">:</td>
            <td class="value">{{ $programData->usia ?? '-' }} Tahun</td>
        </tr>
        <tr>
            <td class="no">6</td>
            <td class="label">Gender/Jenis Kelamin</td>
            <td class="colon">:</td>
            <td class="value">{{ $programData->gender ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">7</td>
            <td class="label">Jumlah Saudara</td>
            <td class="colon">:</td>
            <td class="value">{{ $daftarUlang->jumlah_saudara ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">8</td>
            <td class="label">Provinsi Domisili</td>
            <td class="colon">:</td>
            <td class="value">{{ $programData->provinsi_domisili ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">9</td>
            <td class="label">Kota/Kabupaten</td>
            <td class="colon">:</td>
            <td class="value">{{ $programData->kota_kabupaten ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">10</td>
            <td class="label">Domisili Lengkap</td>
            <td class="colon">:</td>
            <td class="value">{{ $programData->domisili_lengkap ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">11</td>
            <td class="label">NIK</td>
            <td class="colon">:</td>
            <td class="value">{{ $daftarUlang->nik ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">12</td>
            <td class="label">NISN</td>
            <td class="colon">:</td>
            <td class="value">{{ $daftarUlang->nisn ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">13</td>
            <td class="label">Pendidikan Terakhir</td>
            <td class="colon">:</td>
            <td class="value">{{ $programData->pendidikan_terakhir ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">14</td>
            <td class="label">Riwayat Pendidikan Formal</td>
            <td class="colon">:</td>
            <td class="value">{{ $programData->riwayat_pendidikan_formal ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">15</td>
            <td class="label">Riwayat Pendidikan Non Formal</td>
            <td class="colon">:</td>
            <td class="value">{{ $programData->riwayat_pendidikan_nonformal ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">16</td>
            <td class="label">Kelas dan Jenjang Pendidikan</td>
            <td class="colon">:</td>
            <td class="value">{{ $daftarUlang->kelas_jenjang_pendidikan ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">17</td>
            <td class="label">Ukuran Jubah/Gamis</td>
            <td class="colon">:</td>
            <td class="value">{{ $daftarUlang->ukuran_jubah ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">18</td>
            <td class="label">Nomor WA/HP Aktif</td>
            <td class="colon">:</td>
            <td class="value">{{ $programData->no_hp ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">19</td>
            <td class="label">Email Pendaftar</td>
            <td class="colon">:</td>
            <td class="value">{{ $programData->email ?? $registration->user->email ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">20</td>
            <td class="label">Prestasi yang Pernah Diraih</td>
            <td class="colon">:</td>
            <td class="value">{{ $daftarUlang->prestasi ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">21</td>
            <td class="label">Pengalaman Menghafal</td>
            <td class="colon">:</td>
            <td class="value">{{ $daftarUlang->pengalaman_menghafal ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">22</td>
            <td class="label">Jumlah Hafalan (Mutqin/Lancar)</td>
            <td class="colon">:</td>
            <td class="value">{{ $daftarUlang->jumlah_hafalan_juz ?? '-' }} Juz</td>
        </tr>
        <tr>
            <td class="no">23</td>
            <td class="label">Tingkat Pemahaman Tajwid</td>
            <td class="colon">:</td>
            <td class="value">{{ $daftarUlang->pemahaman_tajwid ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">24</td>
            <td class="label">Sumber Informasi PSB</td>
            <td class="colon">:</td>
            <td class="value">{{ $programData->sumber_informasi ?? '-' }}</td>
        </tr>
    </table>

    <div class="section-title">DATA ORANGTUA/WALI</div>

    <table class="data-table">
        <tr>
            <td class="no">25</td>
            <td class="label">Nama Ayah</td>
            <td class="colon">:</td>
            <td class="value">{{ $programData->nama_ayah ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">26</td>
            <td class="label">Pendidikan Terakhir Ayah</td>
            <td class="colon">:</td>
            <td class="value">{{ $daftarUlang->pendidikan_ayah ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">27</td>
            <td class="label">Pekerjaan Ayah</td>
            <td class="colon">:</td>
            <td class="value">{{ $daftarUlang->pekerjaan_ayah ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">28</td>
            <td class="label">Penghasilan Perbulan Ayah</td>
            <td class="colon">:</td>
            <td class="value">{{ $daftarUlang->penghasilan_ayah ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">29</td>
            <td class="label">Nomor Telepon Ayah</td>
            <td class="colon">:</td>
            <td class="value">{{ $daftarUlang->no_telepon_ayah ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">30</td>
            <td class="label">Nama Ibu</td>
            <td class="colon">:</td>
            <td class="value">{{ $programData->nama_ibu ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">31</td>
            <td class="label">Pendidikan Terakhir Ibu</td>
            <td class="colon">:</td>
            <td class="value">{{ $daftarUlang->pendidikan_ibu ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">32</td>
            <td class="label">Pekerjaan Ibu</td>
            <td class="colon">:</td>
            <td class="value">{{ $daftarUlang->pekerjaan_ibu ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">33</td>
            <td class="label">Penghasilan Perbulan Ibu</td>
            <td class="colon">:</td>
            <td class="value">{{ $daftarUlang->penghasilan_ibu ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">34</td>
            <td class="label">Nomor Telepon Ibu</td>
            <td class="colon">:</td>
            <td class="value">{{ $daftarUlang->no_telepon_ibu ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">35</td>
            <td class="label">Nama Wali</td>
            <td class="colon">:</td>
            <td class="value">{{ $daftarUlang->nama_wali ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">36</td>
            <td class="label">Pendidikan Terakhir Wali</td>
            <td class="colon">:</td>
            <td class="value">{{ $daftarUlang->pendidikan_wali ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">37</td>
            <td class="label">Pekerjaan Wali</td>
            <td class="colon">:</td>
            <td class="value">{{ $daftarUlang->pekerjaan_wali ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">38</td>
            <td class="label">Penghasilan Perbulan Wali</td>
            <td class="colon">:</td>
            <td class="value">{{ $daftarUlang->penghasilan_wali ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">39</td>
            <td class="label">Nomor Telepon Wali</td>
            <td class="colon">:</td>
            <td class="value">{{ $daftarUlang->no_telepon_wali ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">40</td>
            <td class="label">Alamat Orangtua/Wali</td>
            <td class="colon">:</td>
            <td class="value">{{ $daftarUlang->alamat_ortu_wali ?? '-' }}</td>
        </tr>
    </table>

    <div class="section-title">DATA TEMPAT TINGGAL</div>

    <table class="data-table">
        <tr>
            <td class="no">41</td>
            <td class="label">Status Rumah</td>
            <td class="colon">:</td>
            <td class="value">{{ $daftarUlang->status_rumah ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">42</td>
            <td class="label">Kondisi Rumah</td>
            <td class="colon">:</td>
            <td class="value">{{ $daftarUlang->kondisi_rumah ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">43</td>
            <td class="label">Perlengkapan Rumah</td>
            <td class="colon">:</td>
            <td class="value">
                @if($daftarUlang && $daftarUlang->perlengkapan_rumah)
                    @if(is_array($daftarUlang->perlengkapan_rumah))
                        {{ implode(', ', $daftarUlang->perlengkapan_rumah) }}
                    @else
                        {{ $daftarUlang->perlengkapan_rumah }}
                    @endif
                @else
                    -
                @endif
            </td>
        </tr>
    </table>

    <div class="section-title">PERNYATAAN PENDAFTAR</div>

    <table class="data-table">
        <tr>
            <td colspan="4" style="padding: 10px;">
                <p style="margin: 5px 0;">
                    ☑ Saya menyatakan bahwa data yang saya isi adalah benar dan dapat dipertanggung jawabkan
                </p>
                <p style="margin: 5px 0;">
                    ☑ Saya bersedia mengikuti aturan dan Program {{ $registration->program->name ?? 'Maskanul Huffadz' }}
                </p>
            </td>
        </tr>
    </table>

    <div class="signature-section">
        <div class="signature-box">
            <p class="date">Tangerang Selatan, {{ date('d F Y') }}</p>
            <p class="name"><strong>{{ $programData->nama_lengkap ?? $registration->user->name }}</strong></p>
            <p style="font-size: 9pt; color: #666;">Peserta PSB Maskanul Huffadz</p>
        </div>
    </div>
</body>
</html>
