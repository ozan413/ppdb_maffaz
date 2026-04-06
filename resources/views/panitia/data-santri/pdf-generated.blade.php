<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Formulir PSB</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            padding: 15px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        
        .header h1 {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 3px;
        }
        
        .header h2 {
            font-size: 12px;
            font-weight: normal;
        }
        
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
        }
        
        .header h1 {
            font-size: 13px;
            font-weight: bold;
            margin: 2px 0;
        }
        
        .main-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .main-table th,
        .main-table td {
            border: 1px solid #000;
            padding: 4px;
            font-size: 10px;
            vertical-align: top;
        }
        
        .section-header {
            background-color: #DAA520;
            font-weight: bold;
            padding: 6px;
            text-align: center;
            font-size: 11px;
        }
        
        .no-col {
            width: 25px;
            text-align: center;
            font-weight: 500;
        }
        
        .label-col {
            width: 40%;
            padding-left: 8px;
        }
        
        .main-table td:nth-child(3) {
            width: 10px;
            text-align: center;
        }
        
        .foto-col {
            width: 120px;
            text-align: center;
            padding: 5px;
            vertical-align: middle;
        }
        
        .foto-col img {
            max-width: 110px;
            max-height: 145px;
            border: 1px solid #000;
        }
        
        .foto-placeholder {
            width: 110px;
            height: 145px;
            border: 1px solid #000;
            display: inline-block;
            padding-top: 60px;
            color: #999;
            font-size: 9px;
        }
        
        .signature-section {
            margin-top: 30px;
            text-align: right;
            padding-right: 60px;
            font-size: 11px;
        }
        
        .signature-line {
            margin-top: 50px;
            display: inline-block;
            min-width: 200px;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <div class="header">
        <h1>FORMULIR PENERIMAAN SANTRI BARU PESANTREN TAHFIDZ</h1>
        <h1>MASKANUL HUFFADZ TAHUN AJARAN {{ $tahunAjaran }}</h1>
    </div>

    <!-- SINGLE TABLE WITH PHOTO -->
    <table class="main-table">
        <thead>
            <tr>
                <th colspan="4" class="section-header">PROFIL CALON SANTRI</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="no-col">1</td>
                <td class="label-col">Nama Lengkap</td>
                <td>:</td>
                <td><strong>{{ $data['nama_lengkap'] ?? '-' }}</strong></td>
                <td rowspan="6" class="foto-col">
                    @if($fotoBase64)
                        <img src="{{ $fotoBase64 }}" alt="Pas Foto">
                    @else
                        <div class="foto-placeholder">PAS FOTO<br>3x4</div>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="no-col">2</td>
                <td class="label-col">Pilihan Program</td>
                <td>:</td>
                <td>{{ $data['program'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="no-col">3</td>
                <td class="label-col">Tempat lahir</td>
                <td>:</td>
                <td>{{ $data['tempat_lahir'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="no-col">4</td>
                <td class="label-col">Tanggal lahir</td>
                <td>:</td>
                <td>{{ $data['tanggal_lahir'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="no-col">5</td>
                <td class="label-col">Usia</td>
                <td>:</td>
                <td>{{ $data['usia'] ?? '-' }} tahun</td>
            </tr>
            <tr>
                <td class="no-col">6</td>
                <td class="label-col">Gender/Jenis kelamin</td>
                <td>:</td>
                <td>{{ $data['gender'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="no-col">7</td>
                <td class="label-col">Jumlah saudara</td>
                <td>:</td>
                <td colspan="2">{{ $data['jumlah_saudara'] ?? '-' }} orang</td>
            </tr>
            <tr>
                <td class="no-col">8</td>
                <td class="label-col">Provinsi Domisili</td>
                <td>:</td>
                <td colspan="2">{{ $data['provinsi'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="no-col">9</td>
                <td class="label-col">Kota/Kabupaten</td>
                <td>:</td>
                <td colspan="2">{{ $data['kota_kabupaten'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="no-col">10</td>
                <td class="label-col">Domisili Lengkap</td>
                <td>:</td>
                <td colspan="2">{{ $data['alamat_lengkap'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="no-col">11</td>
                <td class="label-col">NIK</td>
                <td>:</td>
                <td colspan="2">{{ $data['nik'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="no-col">12</td>
                <td class="label-col">NISN</td>
                <td>:</td>
                <td colspan="2">{{ $data['nisn'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="no-col">13</td>
                <td class="label-col">Pendidikan terakhir</td>
                <td>:</td>
                <td colspan="2">{{ $data['pendidikan_terakhir'] ?? '-' }}</td>
            </tr>
            @if(!empty($data['riwayat_pendidikan_formal']))
            <tr>
                <td class="no-col">14</td>
                <td class="label-col">Riwayat Pendidikan formal (SD SMP SMA)</td>
                <td>:</td>
                <td colspan="2">{{ $data['riwayat_pendidikan_formal'] }}</td>
            </tr>
            @endif
            @if(!empty($data['riwayat_pendidikan_nonformal']))
            <tr>
                <td class="no-col">15</td>
                <td class="label-col">Riwayat Pendidikan non formal</td>
                <td>:</td>
                <td colspan="2">{{ $data['riwayat_pendidikan_nonformal'] }}</td>
            </tr>
            @endif
            @if(!empty($data['kelas_jenjang_pendidikan']))
            <tr>
                <td class="no-col">16</td>
                <td class="label-col">Kelas dan jenjang Pendidikan saat ini</td>
                <td>:</td>
                <td colspan="2">{{ $data['kelas_jenjang_pendidikan'] }}</td>
            </tr>
            @endif
            @if(!empty($data['ukuran_jubah']))
            <tr>
                <td class="no-col">17</td>
                <td class="label-col">Ukuran jubah/gamis</td>
                <td>:</td>
                <td colspan="2">{{ $data['ukuran_jubah'] }}</td>
            </tr>
            @endif
            <tr>
                <td class="no-col">18</td>
                <td class="label-col">Nomor WA/Hp aktif</td>
                <td>:</td>
                <td colspan="2">{{ $data['no_hp'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="no-col">19</td>
                <td class="label-col">Email Pendaftar (untuk konfirmasi)</td>
                <td>:</td>
                <td colspan="2">{{ $data['email'] ?? '-' }}</td>
            </tr>
            @if(!empty($data['prestasi']))
            <tr>
                <td class="no-col">20</td>
                <td class="label-col">Prestasi yang pernah diraih</td>
                <td>:</td>
                <td colspan="2">{{ $data['prestasi'] }}</td>
            </tr>
            @endif
            @if(!empty($data['pengalaman_menghafal']))
            <tr>
                <td class="no-col">21</td>
                <td class="label-col">Pengalaman menghafal</td>
                <td>:</td>
                <td colspan="2">{{ $data['pengalaman_menghafal'] }}</td>
            </tr>
            @endif
            @if(!empty($data['jumlah_hafalan_juz']))
            <tr>
                <td class="no-col">22</td>
                <td class="label-col">Jumlah hafalan (Mutqin/lancar)</td>
                <td>:</td>
                <td colspan="2">{{ $data['jumlah_hafalan_juz'] }} Juz</td>
            </tr>
            @endif
            @if(!empty($data['pemahaman_tajwid']))
            <tr>
                <td class="no-col">23</td>
                <td class="label-col">Tingkat pemahaman materi tajwid</td>
                <td>:</td>
                <td colspan="2">{{ $data['pemahaman_tajwid'] }}</td>
            </tr>
            @endif
            <tr>
                <td class="no-col">24</td>
                <td class="label-col">Nama Ayah</td>
                <td>:</td>
                <td colspan="2">{{ $data['nama_ayah'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="no-col">25</td>
                <td class="label-col">Pendidikan Ayah</td>
                <td>:</td>
                <td colspan="2">{{ $data['pendidikan_ayah'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="no-col">26</td>
                <td class="label-col">Pekerjaan Ayah</td>
                <td>:</td>
                <td colspan="2">{{ $data['pekerjaan_ayah'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="no-col">27</td>
                <td class="label-col">Penghasilan Ayah</td>
                <td>:</td>
                <td colspan="2">{{ $data['penghasilan_ayah'] ?? '-' }}</td>
            </tr>
            @if(!empty($data['no_telepon_ayah']))
            <tr>
                <td class="no-col">28</td>
                <td class="label-col">No. Telepon Ayah</td>
                <td>:</td>
                <td colspan="2">{{ $data['no_telepon_ayah'] }}</td>
            </tr>
            @endif
            <tr>
                <td class="no-col">29</td>
                <td class="label-col">Nama Ibu</td>
                <td>:</td>
                <td colspan="2">{{ $data['nama_ibu'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="no-col">30</td>
                <td class="label-col">Pendidikan Ibu</td>
                <td>:</td>
                <td colspan="2">{{ $data['pendidikan_ibu'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="no-col">31</td>
                <td class="label-col">Pekerjaan Ibu</td>
                <td>:</td>
                <td colspan="2">{{ $data['pekerjaan_ibu'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="no-col">32</td>
                <td class="label-col">Penghasilan Ibu</td>
                <td>:</td>
                <td colspan="2">{{ $data['penghasilan_ibu'] ?? '-' }}</td>
            </tr>
            @if(!empty($data['no_telepon_ibu']))
            <tr>
                <td class="no-col">33</td>
                <td class="label-col">No. Telepon Ibu</td>
                <td>:</td>
                <td colspan="2">{{ $data['no_telepon_ibu'] }}</td>
            </tr>
            @endif
            @if(!empty($data['nama_wali']))
            <tr>
                <td class="no-col">34</td>
                <td class="label-col">Nama Wali</td>
                <td>:</td>
                <td colspan="2">{{ $data['nama_wali'] }}</td>
            </tr>
            @endif
            @if(!empty($data['alamat_ortu_wali']))
            <tr>
                <td class="no-col">35</td>
                <td class="label-col">Alamat Orang Tua/Wali</td>
                <td>:</td>
                <td colspan="2">{{ $data['alamat_ortu_wali'] }}</td>
            </tr>
            @endif
            @if(!empty($data['sumber_informasi']))
            <tr>
                <td class="no-col">36</td>
                <td class="label-col">Sumber Informasi</td>
                <td>:</td>
                <td colspan="2">{{ $data['sumber_informasi'] }}</td>
            </tr>
            @endif
        </tbody>
    </table>

    <!-- TANDA TANGAN -->
    <div class="signature-section">
        <div>{{ date('d F Y') }}</div>
        <div style="margin-top: 5px;">Calon Santri,</div>
        <div class="signature-line">
            <strong>{{ $data['nama_lengkap'] ?? '(______________________)' }}</strong>
        </div>
    </div>
</body>
</html>
