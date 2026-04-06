@extends('layouts.santri')

@section('title', 'Daftar Ulang - Lil Athfal')

@section('content')
<div class="page-header">
    <h1>Formulir Daftar Ulang</h1>
    <p>Program: <strong>{{ $registration->program->name }}</strong></p>
</div>

<form action="{{ route('santri.daftar-ulang.lil-athfal') }}" method="POST" enctype="multipart/form-data">
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
                    <label>Keterangan Kondisi Orangtua <span style="color: red;">*</span></label>
                    <select name="kondisi_ortu" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="Lengkap">Lengkap</option>
                        <option value="Yatim">Yatim</option>
                        <option value="Piatu">Piatu</option>
                        <option value="Yatim Piatu">Yatim Piatu</option>
                        <option value="Cerai">Cerai</option>
                    </select>
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
                <label>Riwayat Pendidikan Formal (SD, SMP) <span style="color: red;">*</span></label>
                <textarea name="riwayat_pendidikan_formal" class="form-control" rows="2" required placeholder="Contoh: SD Negeri 1 Jakarta (2018-2024)"></textarea>
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
            <h3><i class="fas fa-trophy"></i> Prestasi & Hafalan</h3>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label>Prestasi Yang Pernah Diraih</label>
                <textarea name="prestasi" class="form-control" rows="2" placeholder="Format: Nama Lomba, Tahun, Juara, Tingkat&#10;Contoh: Lomba MTQ, 2024, Juara 1, Kabupaten"></textarea>
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label>Jumlah Hafalan (Mutqin/Lancar) <span style="color: red;">*</span></label>
                <input type="text" name="jumlah_hafalan" class="form-control" required placeholder="Contoh: 3 Juz, atau Juz 30 + Juz 29">
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
