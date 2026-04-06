@extends('layouts.santri')

@section('title', "Daftar Ulang - I'dad Tahfidz")

@section('content')
<div class="page-header">
    <h1>Formulir Daftar Ulang</h1>
    <p>Program: <strong>{{ $registration->program->name }}</strong></p>
</div>

<form action="{{ route('santri.daftar-ulang.iddah-tahfidz') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-id-card"></i> Data Identitas</h3>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group">
                    <label>Jumlah Saudara <span style="color: red;">*</span></label>
                    <input type="number" name="jumlah_saudara" class="form-control" min="0" max="15" required>
                </div>
                <div class="form-group">
                    <label>Kelas & Jenjang Pendidikan Saat Ini <span style="color: red;">*</span></label>
                    <input type="text" name="kelas_jenjang_pendidikan" class="form-control" required placeholder="Contoh: Kelas 12 SMA">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>NIK (16 digit) <span style="color: red;">*</span></label>
                    <input type="text" name="nik" class="form-control" maxlength="16" pattern="[0-9]{16}" required placeholder="3201234567890123">
                </div>
                <div class="form-group">
                    <label>NISN (10 digit) <span style="color: red;">*</span></label>
                    <input type="text" name="nisn" class="form-control" maxlength="10" pattern="[0-9]{10}" required placeholder="0012345678">
                </div>
            </div>
            <div class="form-group">
                <label>Riwayat Pendidikan Formal (SD, SMP, SMA) <span style="color: red;">*</span></label>
                <textarea name="riwayat_pendidikan_formal" class="form-control" rows="3" required placeholder="Contoh:&#10;SD Negeri 1 Jakarta (2012-2018)&#10;SMP Negeri 1 Jakarta (2018-2021)&#10;SMA Negeri 1 Jakarta (2021-sekarang)"></textarea>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-camera"></i> Foto Santri</h3>
        </div>
        <div class="card-body">
            <div class="form-group" style="margin-bottom: 0;">
                <label>Foto Santri 3x4 (Background Biru) <span style="color: red;">*</span></label>
                <input type="file" name="pas_foto" class="form-control" accept="image/*" required>
                <small style="color: #666;">Format: JPG, PNG. Maksimal 2MB. Background warna biru.</small>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-trophy"></i> Prestasi</h3>
        </div>
        <div class="card-body">
            <div class="form-group" style="margin-bottom: 0;">
                <label>Prestasi Yang Pernah Diraih</label>
                <textarea name="prestasi" class="form-control" rows="2" placeholder="Format: Nama Lomba, Tahun, Juara, Tingkat&#10;Contoh: Lomba MTQ, 2024, Juara 1, Kabupaten"></textarea>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-quran"></i> Pengalaman Menghafal Al-Quran</h3>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group">
                    <label>Pengalaman Menghafal <span style="color: red;">*</span></label>
                    <select name="pengalaman_menghafal" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="Pernah">Pernah</option>
                        <option value="Belum">Belum</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Jumlah Hafalan (Mutqin/Lancar)</label>
                    <input type="text" name="jumlah_hafalan_juz" class="form-control" placeholder="Contoh: 5 Juz">
                </div>
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label>Tingkat Pemahaman Materi Tajwid <span style="color: red;">*</span></label>
                <select name="pemahaman_tajwid" class="form-control" required>
                    <option value="">-- Pilih --</option>
                    <option value="Sudah Menguasai">Sudah Menguasai</option>
                    <option value="Pernah Belajar tetapi Belum Menguasai">Pernah Belajar tetapi Belum Menguasai</option>
                    <option value="Belum Pernah Belajar">Belum Pernah Belajar</option>
                </select>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-users"></i> Data Pendidikan Orangtua</h3>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group">
                    <label>Pendidikan Terakhir Ayah <span style="color: red;">*</span></label>
                    <select name="pendidikan_ayah" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="SD/MI">SD/MI</option>
                        <option value="SMP/MTs">SMP/MTs</option>
                        <option value="SMA/SMK/MA">SMA/SMK/MA</option>
                        <option value="D1/D2/D3">D1/D2/D3</option>
                        <option value="S1">S1</option>
                        <option value="S2">S2</option>
                        <option value="S3">S3</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Pendidikan Terakhir Ibu <span style="color: red;">*</span></label>
                    <select name="pendidikan_ibu" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="SD/MI">SD/MI</option>
                        <option value="SMP/MTs">SMP/MTs</option>
                        <option value="SMA/SMK/MA">SMA/SMK/MA</option>
                        <option value="D1/D2/D3">D1/D2/D3</option>
                        <option value="S1">S1</option>
                        <option value="S2">S2</option>
                        <option value="S3">S3</option>
                    </select>
                </div>
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label>Pendidikan Terakhir Wali</label>
                <select name="pendidikan_wali" class="form-control">
                    <option value="">-- Pilih --</option>
                    <option value="SD/MI">SD/MI</option>
                    <option value="SMP/MTs">SMP/MTs</option>
                    <option value="SMA/SMK/MA">SMA/SMK/MA</option>
                    <option value="D1/D2/D3">D1/D2/D3</option>
                    <option value="S1">S1</option>
                    <option value="S2">S2</option>
                    <option value="S3">S3</option>
                </select>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-home"></i> Kondisi Rumah</h3>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group">
                    <label>Status Rumah <span style="color: red;">*</span></label>
                    <select name="status_rumah" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="Milik Orang Tua">Milik Orang Tua</option>
                        <option value="Milik Pribadi">Milik Pribadi</option>
                        <option value="Rumah Dinas">Rumah Dinas</option>
                        <option value="Kontrakan/Sewa">Kontrakan/Sewa</option>
                        <option value="Menumpang">Menumpang</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Kondisi Rumah <span style="color: red;">*</span></label>
                    <select name="kondisi_rumah" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="Gubuk">Gubuk</option>
                        <option value="Semi Permanen">Semi Permanen</option>
                        <option value="Permanen">Permanen</option>
                    </select>
                </div>
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label>Perlengkapan Rumah (centang yang dimiliki)</label>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 10px; padding: 15px; background: var(--off-white); border-radius: 10px;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" name="perlengkapan_rumah[]" value="kamar_tidur"> Kamar Tidur
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" name="perlengkapan_rumah[]" value="ruang_tamu"> Ruang Tamu
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" name="perlengkapan_rumah[]" value="kamar_mandi"> Kamar Mandi
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" name="perlengkapan_rumah[]" value="wc"> WC
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" name="perlengkapan_rumah[]" value="mesin_cuci"> Mesin Cuci
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" name="perlengkapan_rumah[]" value="kulkas"> Kulkas
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" name="perlengkapan_rumah[]" value="tv"> TV
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" name="perlengkapan_rumah[]" value="komputer_laptop"> Komputer/Laptop
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" name="perlengkapan_rumah[]" value="motor"> Motor
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" name="perlengkapan_rumah[]" value="mobil"> Mobil
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-file-signature"></i> Pernyataan</h3>
        </div>
        <div class="card-body">
            <div style="background: rgba(46, 125, 50, 0.1); padding: 20px; border-radius: 10px;">
                <label style="display: flex; align-items: flex-start; gap: 12px; cursor: pointer; margin-bottom: 15px;">
                    <input type="checkbox" name="pernyataan_data_benar" value="1" required style="margin-top: 4px;">
                    <span>Saya menyatakan bahwa data yang saya isi adalah <strong>benar dan dapat dipertanggungjawabkan</strong>.</span>
                </label>
                <label style="display: flex; align-items: flex-start; gap: 12px; cursor: pointer;">
                    <input type="checkbox" name="pernyataan_ikut_aturan" value="1" required style="margin-top: 4px;">
                    <span>Saya bersedia <strong>mengikuti seluruh aturan dan ketentuan</strong> yang berlaku di pesantren.</span>
                </label>
            </div>
        </div>
    </div>

    <div style="display: flex; gap: 15px; margin-top: 20px;">
        <a href="{{ route('santri.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <button type="submit" class="btn btn-primary" style="flex: 1;">
            <i class="fas fa-save"></i> Simpan Daftar Ulang
        </button>
    </div>
</form>
@endsection
