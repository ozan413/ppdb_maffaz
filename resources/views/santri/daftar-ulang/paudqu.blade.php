@extends('layouts.santri')

@section('title', 'Daftar Ulang - PaudQu')

@section('content')
<div class="page-header">
    <h1>Formulir Daftar Ulang</h1>
    <p>Program: <strong>{{ $registration->program->name }}</strong></p>
</div>

<form action="{{ route('santri.daftar-ulang.paudqu') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-child"></i> Data Identitas Anak</h3>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group">
                    <label>Anak Ke <span style="color: red;">*</span></label>
                    <input type="number" name="anak_ke" class="form-control" min="1" max="15" required>
                </div>
                <div class="form-group">
                    <label>Jumlah Saudara <span style="color: red;">*</span></label>
                    <input type="number" name="jumlah_saudara" class="form-control" min="0" max="15" required>
                </div>
            </div>
            <div class="form-group">
                <label>NIK (16 digit) <span style="color: red;">*</span></label>
                <input type="text" name="nik" class="form-control" maxlength="16" pattern="[0-9]{16}" required placeholder="3201234567890123">
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-male"></i> Data Ayah</h3>
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
                    <label>Pekerjaan Ayah <span style="color: red;">*</span></label>
                    <select name="pekerjaan_ayah" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="PNS">PNS</option>
                        <option value="TNI/POLRI">TNI/POLRI</option>
                        <option value="Wiraswasta">Wiraswasta</option>
                        <option value="Karyawan Swasta">Karyawan Swasta</option>
                        <option value="Petani">Petani</option>
                        <option value="Buruh">Buruh</option>
                        <option value="Pedagang">Pedagang</option>
                        <option value="Guru/Dosen">Guru/Dosen</option>
                        <option value="Tidak Bekerja">Tidak Bekerja</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Penghasilan Perbulan Ayah <span style="color: red;">*</span></label>
                <select name="penghasilan_ayah" class="form-control" required>
                    <option value="">-- Pilih --</option>
                    <option value="0 - Rp. 500.000">0 - Rp. 500.000</option>
                    <option value="Rp. 500.000 - Rp. 1.500.000">Rp. 500.000 - Rp. 1.500.000</option>
                    <option value="Rp. 1.500.000 - Rp. 3.000.000">Rp. 1.500.000 - Rp. 3.000.000</option>
                    <option value="Rp. 3.000.000 - Rp. 5.000.000">Rp. 3.000.000 - Rp. 5.000.000</option>
                    <option value="Diatas Rp. 5.000.000">Diatas Rp. 5.000.000</option>
                </select>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-female"></i> Data Ibu</h3>
        </div>
        <div class="card-body">
            <div class="form-row">
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
                <div class="form-group">
                    <label>Pekerjaan Ibu <span style="color: red;">*</span></label>
                    <select name="pekerjaan_ibu" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                        <option value="PNS">PNS</option>
                        <option value="Wiraswasta">Wiraswasta</option>
                        <option value="Karyawan Swasta">Karyawan Swasta</option>
                        <option value="Petani">Petani</option>
                        <option value="Pedagang">Pedagang</option>
                        <option value="Guru/Dosen">Guru/Dosen</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Penghasilan Perbulan Ibu <span style="color: red;">*</span></label>
                <select name="penghasilan_ibu" class="form-control" required>
                    <option value="">-- Pilih --</option>
                    <option value="0 - Rp. 500.000">0 - Rp. 500.000</option>
                    <option value="Rp. 500.000 - Rp. 1.500.000">Rp. 500.000 - Rp. 1.500.000</option>
                    <option value="Rp. 1.500.000 - Rp. 3.000.000">Rp. 1.500.000 - Rp. 3.000.000</option>
                    <option value="Rp. 3.000.000 - Rp. 5.000.000">Rp. 3.000.000 - Rp. 5.000.000</option>
                    <option value="Diatas Rp. 5.000.000">Diatas Rp. 5.000.000</option>
                </select>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-user-shield"></i> Data Wali (Opsional)</h3>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group">
                    <label>Nama Wali</label>
                    <input type="text" name="nama_wali" class="form-control">
                </div>
                <div class="form-group">
                    <label>Nomor Telepon Wali</label>
                    <input type="text" name="no_telepon_wali" class="form-control" maxlength="15" placeholder="08xxxxxxxxxx">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
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
                <div class="form-group">
                    <label>Pekerjaan Wali</label>
                    <select name="pekerjaan_wali" class="form-control">
                        <option value="">-- Pilih --</option>
                        <option value="PNS">PNS</option>
                        <option value="Wiraswasta">Wiraswasta</option>
                        <option value="Karyawan Swasta">Karyawan Swasta</option>
                        <option value="Petani">Petani</option>
                        <option value="Pedagang">Pedagang</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Penghasilan Perbulan Wali</label>
                <select name="penghasilan_wali" class="form-control">
                    <option value="">-- Pilih --</option>
                    <option value="0 - Rp. 500.000">0 - Rp. 500.000</option>
                    <option value="Rp. 500.000 - Rp. 1.500.000">Rp. 500.000 - Rp. 1.500.000</option>
                    <option value="Rp. 1.500.000 - Rp. 3.000.000">Rp. 1.500.000 - Rp. 3.000.000</option>
                    <option value="Rp. 3.000.000 - Rp. 5.000.000">Rp. 3.000.000 - Rp. 5.000.000</option>
                    <option value="Diatas Rp. 5.000.000">Diatas Rp. 5.000.000</option>
                </select>
            </div>
            <div class="form-group">
                <label>Alamat Orangtua/Wali <span style="color: red;">*</span></label>
                <textarea name="alamat_ortu_wali" class="form-control" rows="2" required></textarea>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-camera"></i> Pas Foto</h3>
        </div>
        <div class="card-body">
            <div class="form-group" style="margin-bottom: 0;">
                <label>Pas Foto Anak 3x4 (Background Biru) <span style="color: red;">*</span></label>
                <input type="file" name="pas_foto" class="form-control" accept="image/*" required>
                <small style="color: #666;">Format: JPG, PNG. Maksimal 2MB. Background warna biru.</small>
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
                    <span>Saya bersedia <strong>mengikuti seluruh aturan dan ketentuan</strong> yang berlaku.</span>
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
