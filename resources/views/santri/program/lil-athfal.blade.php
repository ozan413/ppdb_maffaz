@extends('layouts.santri')

@section('title', 'Formulir Lil Athfal')

@section('content')
<div class="page-header">
    <h1>Formulir Pendaftaran - Lil Athfal</h1>
    <p>Lengkapi data berikut untuk mendaftar program Lil Athfal</p>
</div>

<form action="{{ route('santri.program.store', 'lil-athfal') }}" method="POST">
    @csrf

    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-list"></i> Pilihan Program</h3>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group">
                    <label>Jalur Program <span style="color: red;">*</span></label>
                    <select name="program_pilihan" class="form-control @error('program_pilihan') is-invalid @enderror" required>
                        <option value="">-- Pilih Program --</option>
                        <option value="Lil Athfal Reguler" {{ old('program_pilihan', $data->program_pilihan ?? '') == 'Lil Athfal Reguler' ? 'selected' : '' }}>Lil Athfal Reguler</option>
                        <option value="Lil Athfal Beasiswa" {{ old('program_pilihan', $data->program_pilihan ?? '') == 'Lil Athfal Beasiswa' ? 'selected' : '' }}>Lil Athfal Beasiswa</option>
                    </select>
                    @error('program_pilihan') <small class="text-error">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <label>Jalur Masuk Program <span style="color: red;">*</span></label>
                    <select name="jalur_masuk_program" class="form-control" required>
                        <option value="">-- Pilih Jalur --</option>
                        <option value="Reguler" {{ old('jalur_masuk_program', $data->jalur_masuk_program ?? '') == 'Reguler' ? 'selected' : '' }}>Reguler</option>
                        <option value="Beasiswa" {{ old('jalur_masuk_program', $data->jalur_masuk_program ?? '') == 'Beasiswa' ? 'selected' : '' }}>Beasiswa</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-user"></i> Data Pribadi</h3>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label>Nama Lengkap <span style="color: red;">*</span></label>
                <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap', $data->nama_lengkap ?? '') }}" required>
                @error('nama_lengkap') <small class="text-error">{{ $message }}</small> @enderror
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Tempat Lahir <span style="color: red;">*</span></label>
                    <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir', $data->tempat_lahir ?? '') }}" required>
                    @error('tempat_lahir') <small class="text-error">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <label>Tanggal Lahir <span style="color: red;">*</span></label>
                    <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir', $data->tanggal_lahir ?? '') }}" required>
                    @error('tanggal_lahir') <small class="text-error">{{ $message }}</small> @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Usia <span style="color: red;">*</span></label>
                    <input type="text" name="usia" class="form-control @error('usia') is-invalid @enderror" value="{{ old('usia', $data->usia ?? '') }}" placeholder="Contoh: 12 Tahun 6 Bulan" required>
                    @error('usia') <small class="text-error">{{ $message }}</small> @enderror
                    <small style="color: #666;">*Usia saat memasuki bulan Juni 2026</small>
                </div>
                <div class="form-group">
                    <label>Gender <span style="color: red;">*</span></label>
                    <select name="gender" class="form-control @error('gender') is-invalid @enderror" required>
                        <option value="">-- Pilih --</option>
                        <option value="Laki-Laki" {{ old('gender', $data->gender ?? '') == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                        <option value="Perempuan" {{ old('gender', $data->gender ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('gender') <small class="text-error">{{ $message }}</small> @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Pendidikan Terakhir <span style="color: red;">*</span></label>
                    <select name="pendidikan_terakhir" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="Tidak Sekolah" {{ old('pendidikan_terakhir', $data->pendidikan_terakhir ?? '') == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                        <option value="TK/PAUD" {{ old('pendidikan_terakhir', $data->pendidikan_terakhir ?? '') == 'TK/PAUD' ? 'selected' : '' }}>TK/PAUD</option>
                        <option value="SD/MI" {{ old('pendidikan_terakhir', $data->pendidikan_terakhir ?? '') == 'SD/MI' ? 'selected' : '' }}>SD/MI</option>
                        <option value="SMP/MTs" {{ old('pendidikan_terakhir', $data->pendidikan_terakhir ?? '') == 'SMP/MTs' ? 'selected' : '' }}>SMP/MTs</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tingkat Pemahaman Ilmu Tajwid <span style="color: red;">*</span></label>
                    <select name="pemahaman_tajwid" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="Sudah Menguasai" {{ old('pemahaman_tajwid', $data->pemahaman_tajwid ?? '') == 'Sudah Menguasai' ? 'selected' : '' }}>Sudah Menguasai</option>
                        <option value="Pernah Belajar tetapi Belum Menguasai" {{ old('pemahaman_tajwid', $data->pemahaman_tajwid ?? '') == 'Pernah Belajar tetapi Belum Menguasai' ? 'selected' : '' }}>Pernah Belajar tetapi Belum Menguasai</option>
                        <option value="Belum Pernah Belajar" {{ old('pemahaman_tajwid', $data->pemahaman_tajwid ?? '') == 'Belum Pernah Belajar' ? 'selected' : '' }}>Belum Pernah Belajar</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Riwayat Pendidikan Non Formal</label>
                <textarea name="riwayat_pendidikan_nonformal" class="form-control" rows="2" placeholder="Contoh: TPQ, Madrasah Diniyah, dll">{{ old('riwayat_pendidikan_nonformal', $data->riwayat_pendidikan_nonformal ?? '') }}</textarea>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-map-marker-alt"></i> Alamat Domisili</h3>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group">
                    <label>Provinsi <span style="color: red;">*</span></label>
                    <input type="text" name="provinsi_domisili" class="form-control @error('provinsi_domisili') is-invalid @enderror" value="{{ old('provinsi_domisili', $data->provinsi_domisili ?? '') }}" required>
                    @error('provinsi_domisili') <small class="text-error">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <label>Kabupaten <span style="color: red;">*</span></label>
                    <input type="text" name="kota_kabupaten" class="form-control @error('kota_kabupaten') is-invalid @enderror" value="{{ old('kota_kabupaten', $data->kota_kabupaten ?? '') }}" required>
                    @error('kota_kabupaten') <small class="text-error">{{ $message }}</small> @enderror
                </div>
            </div>
            <div class="form-group">
                <label>Alamat Lengkap Domisili <span style="color: red;">*</span></label>
                <textarea name="domisili_lengkap" class="form-control @error('domisili_lengkap') is-invalid @enderror" rows="2" required>{{ old('domisili_lengkap', $data->domisili_lengkap ?? '') }}</textarea>
                @error('domisili_lengkap') <small class="text-error">{{ $message }}</small> @enderror
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-info-circle"></i> Sumber Informasi</h3>
        </div>
        <div class="card-body">
            <div class="form-group" style="margin-bottom: 0;">
                <label>Dari Mana Mendapatkan Informasi PSB <span style="color: red;">*</span></label>
                <select name="sumber_informasi" class="form-control" required>
                    <option value="">-- Pilih --</option>
                    <option value="Instagram" {{ old('sumber_informasi', $data->sumber_informasi ?? '') == 'Instagram' ? 'selected' : '' }}>Instagram</option>
                    <option value="Facebook" {{ old('sumber_informasi', $data->sumber_informasi ?? '') == 'Facebook' ? 'selected' : '' }}>Facebook</option>
                    <option value="Website" {{ old('sumber_informasi', $data->sumber_informasi ?? '') == 'Website' ? 'selected' : '' }}>Website</option>
                    <option value="Teman/Keluarga" {{ old('sumber_informasi', $data->sumber_informasi ?? '') == 'Teman/Keluarga' ? 'selected' : '' }}>Teman/Keluarga</option>
                    <option value="Brosur" {{ old('sumber_informasi', $data->sumber_informasi ?? '') == 'Brosur' ? 'selected' : '' }}>Brosur</option>
                    <option value="Alumni" {{ old('sumber_informasi', $data->sumber_informasi ?? '') == 'Alumni' ? 'selected' : '' }}>Alumni</option>
                    <option value="Lainnya" {{ old('sumber_informasi', $data->sumber_informasi ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
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
                    <label>Nama Ayah <span style="color: red;">*</span></label>
                    <input type="text" name="nama_ayah" class="form-control @error('nama_ayah') is-invalid @enderror" value="{{ old('nama_ayah', $data->nama_ayah ?? '') }}" required>
                    @error('nama_ayah') <small class="text-error">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <label>Nomor HP/WA Ayah <span style="color: red;">*</span></label>
                    <input type="text" name="no_telepon_ayah" class="form-control" value="{{ old('no_telepon_ayah', $data->no_telepon_ayah ?? '') }}" placeholder="08xxxxxxxxxx" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Pekerjaan Ayah <span style="color: red;">*</span></label>
                    <select name="pekerjaan_ayah" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="PNS" {{ old('pekerjaan_ayah', $data->pekerjaan_ayah ?? '') == 'PNS' ? 'selected' : '' }}>PNS</option>
                        <option value="TNI/POLRI" {{ old('pekerjaan_ayah', $data->pekerjaan_ayah ?? '') == 'TNI/POLRI' ? 'selected' : '' }}>TNI/POLRI</option>
                        <option value="Wiraswasta" {{ old('pekerjaan_ayah', $data->pekerjaan_ayah ?? '') == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                        <option value="Karyawan Swasta" {{ old('pekerjaan_ayah', $data->pekerjaan_ayah ?? '') == 'Karyawan Swasta' ? 'selected' : '' }}>Karyawan Swasta</option>
                        <option value="Petani" {{ old('pekerjaan_ayah', $data->pekerjaan_ayah ?? '') == 'Petani' ? 'selected' : '' }}>Petani</option>
                        <option value="Buruh" {{ old('pekerjaan_ayah', $data->pekerjaan_ayah ?? '') == 'Buruh' ? 'selected' : '' }}>Buruh</option>
                        <option value="Pedagang" {{ old('pekerjaan_ayah', $data->pekerjaan_ayah ?? '') == 'Pedagang' ? 'selected' : '' }}>Pedagang</option>
                        <option value="Guru/Dosen" {{ old('pekerjaan_ayah', $data->pekerjaan_ayah ?? '') == 'Guru/Dosen' ? 'selected' : '' }}>Guru/Dosen</option>
                        <option value="Tidak Bekerja" {{ old('pekerjaan_ayah', $data->pekerjaan_ayah ?? '') == 'Tidak Bekerja' ? 'selected' : '' }}>Tidak Bekerja</option>
                        <option value="Lainnya" {{ old('pekerjaan_ayah', $data->pekerjaan_ayah ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Penghasilan Perbulan Ayah <span style="color: red;">*</span></label>
                    <select name="penghasilan_ayah" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="0 - Rp. 500.000" {{ old('penghasilan_ayah', $data->penghasilan_ayah ?? '') == '0 - Rp. 500.000' ? 'selected' : '' }}>0 - Rp. 500.000</option>
                        <option value="Rp. 500.000 - Rp. 1.500.000" {{ old('penghasilan_ayah', $data->penghasilan_ayah ?? '') == 'Rp. 500.000 - Rp. 1.500.000' ? 'selected' : '' }}>Rp. 500.000 - Rp. 1.500.000</option>
                        <option value="Rp. 1.500.000 - Rp. 3.000.000" {{ old('penghasilan_ayah', $data->penghasilan_ayah ?? '') == 'Rp. 1.500.000 - Rp. 3.000.000' ? 'selected' : '' }}>Rp. 1.500.000 - Rp. 3.000.000</option>
                        <option value="Rp. 3.000.000 - Rp. 5.000.000" {{ old('penghasilan_ayah', $data->penghasilan_ayah ?? '') == 'Rp. 3.000.000 - Rp. 5.000.000' ? 'selected' : '' }}>Rp. 3.000.000 - Rp. 5.000.000</option>
                        <option value="Diatas Rp. 5.000.000" {{ old('penghasilan_ayah', $data->penghasilan_ayah ?? '') == 'Diatas Rp. 5.000.000' ? 'selected' : '' }}>Diatas Rp. 5.000.000</option>
                    </select>
                </div>
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
                    <label>Nama Ibu <span style="color: red;">*</span></label>
                    <input type="text" name="nama_ibu" class="form-control @error('nama_ibu') is-invalid @enderror" value="{{ old('nama_ibu', $data->nama_ibu ?? '') }}" required>
                    @error('nama_ibu') <small class="text-error">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <label>Nomor HP/WA Ibu <span style="color: red;">*</span></label>
                    <input type="text" name="no_telepon_ibu" class="form-control" value="{{ old('no_telepon_ibu', $data->no_telepon_ibu ?? '') }}" placeholder="08xxxxxxxxxx" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Pekerjaan Ibu <span style="color: red;">*</span></label>
                    <select name="pekerjaan_ibu" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="PNS" {{ old('pekerjaan_ibu', $data->pekerjaan_ibu ?? '') == 'PNS' ? 'selected' : '' }}>PNS</option>
                        <option value="Ibu Rumah Tangga" {{ old('pekerjaan_ibu', $data->pekerjaan_ibu ?? '') == 'Ibu Rumah Tangga' ? 'selected' : '' }}>Ibu Rumah Tangga</option>
                        <option value="Wiraswasta" {{ old('pekerjaan_ibu', $data->pekerjaan_ibu ?? '') == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                        <option value="Karyawan Swasta" {{ old('pekerjaan_ibu', $data->pekerjaan_ibu ?? '') == 'Karyawan Swasta' ? 'selected' : '' }}>Karyawan Swasta</option>
                        <option value="Petani" {{ old('pekerjaan_ibu', $data->pekerjaan_ibu ?? '') == 'Petani' ? 'selected' : '' }}>Petani</option>
                        <option value="Pedagang" {{ old('pekerjaan_ibu', $data->pekerjaan_ibu ?? '') == 'Pedagang' ? 'selected' : '' }}>Pedagang</option>
                        <option value="Guru/Dosen" {{ old('pekerjaan_ibu', $data->pekerjaan_ibu ?? '') == 'Guru/Dosen' ? 'selected' : '' }}>Guru/Dosen</option>
                        <option value="Lainnya" {{ old('pekerjaan_ibu', $data->pekerjaan_ibu ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Penghasilan Perbulan Ibu <span style="color: red;">*</span></label>
                    <select name="penghasilan_ibu" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="0 - Rp. 500.000" {{ old('penghasilan_ibu', $data->penghasilan_ibu ?? '') == '0 - Rp. 500.000' ? 'selected' : '' }}>0 - Rp. 500.000</option>
                        <option value="Rp. 500.000 - Rp. 1.500.000" {{ old('penghasilan_ibu', $data->penghasilan_ibu ?? '') == 'Rp. 500.000 - Rp. 1.500.000' ? 'selected' : '' }}>Rp. 500.000 - Rp. 1.500.000</option>
                        <option value="Rp. 1.500.000 - Rp. 3.000.000" {{ old('penghasilan_ibu', $data->penghasilan_ibu ?? '') == 'Rp. 1.500.000 - Rp. 3.000.000' ? 'selected' : '' }}>Rp. 1.500.000 - Rp. 3.000.000</option>
                        <option value="Rp. 3.000.000 - Rp. 5.000.000" {{ old('penghasilan_ibu', $data->penghasilan_ibu ?? '') == 'Rp. 3.000.000 - Rp. 5.000.000' ? 'selected' : '' }}>Rp. 3.000.000 - Rp. 5.000.000</option>
                        <option value="Diatas Rp. 5.000.000" {{ old('penghasilan_ibu', $data->penghasilan_ibu ?? '') == 'Diatas Rp. 5.000.000' ? 'selected' : '' }}>Diatas Rp. 5.000.000</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-user-shield"></i> Data Wali</h3>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group">
                    <label>Nama Wali</label>
                    <input type="text" name="nama_wali" class="form-control" value="{{ old('nama_wali', $data->nama_wali ?? '') }}">
                </div>
                <div class="form-group">
                    <label>Nomor HP/WA Wali</label>
                    <input type="text" name="no_telepon_wali" class="form-control" value="{{ old('no_telepon_wali', $data->no_telepon_wali ?? '') }}" placeholder="08xxxxxxxxxx">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Pekerjaan Wali</label>
                    <select name="pekerjaan_wali" class="form-control">
                        <option value="">-- Pilih --</option>
                        <option value="PNS" {{ old('pekerjaan_wali', $data->pekerjaan_wali ?? '') == 'PNS' ? 'selected' : '' }}>PNS</option>
                        <option value="Wiraswasta" {{ old('pekerjaan_wali', $data->pekerjaan_wali ?? '') == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                        <option value="Karyawan Swasta" {{ old('pekerjaan_wali', $data->pekerjaan_wali ?? '') == 'Karyawan Swasta' ? 'selected' : '' }}>Karyawan Swasta</option>
                        <option value="Petani" {{ old('pekerjaan_wali', $data->pekerjaan_wali ?? '') == 'Petani' ? 'selected' : '' }}>Petani</option>
                        <option value="Pedagang" {{ old('pekerjaan_wali', $data->pekerjaan_wali ?? '') == 'Pedagang' ? 'selected' : '' }}>Pedagang</option>
                        <option value="Lainnya" {{ old('pekerjaan_wali', $data->pekerjaan_wali ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Penghasilan Perbulan Wali</label>
                    <select name="penghasilan_wali" class="form-control">
                        <option value="">-- Pilih --</option>
                        <option value="0 - Rp. 500.000" {{ old('penghasilan_wali', $data->penghasilan_wali ?? '') == '0 - Rp. 500.000' ? 'selected' : '' }}>0 - Rp. 500.000</option>
                        <option value="Rp. 500.000 - Rp. 1.500.000" {{ old('penghasilan_wali', $data->penghasilan_wali ?? '') == 'Rp. 500.000 - Rp. 1.500.000' ? 'selected' : '' }}>Rp. 500.000 - Rp. 1.500.000</option>
                        <option value="Rp. 1.500.000 - Rp. 3.000.000" {{ old('penghasilan_wali', $data->penghasilan_wali ?? '') == 'Rp. 1.500.000 - Rp. 3.000.000' ? 'selected' : '' }}>Rp. 1.500.000 - Rp. 3.000.000</option>
                        <option value="Rp. 3.000.000 - Rp. 5.000.000" {{ old('penghasilan_wali', $data->penghasilan_wali ?? '') == 'Rp. 3.000.000 - Rp. 5.000.000' ? 'selected' : '' }}>Rp. 3.000.000 - Rp. 5.000.000</option>
                        <option value="Diatas Rp. 5.000.000" {{ old('penghasilan_wali', $data->penghasilan_wali ?? '') == 'Diatas Rp. 5.000.000' ? 'selected' : '' }}>Diatas Rp. 5.000.000</option>
                    </select>
                </div>
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label>Alamat Orangtua/Wali <span style="color: red;">*</span></label>
                <textarea name="alamat_ortu_wali" class="form-control" rows="2" required>{{ old('alamat_ortu_wali', $data->alamat_ortu_wali ?? '') }}</textarea>
            </div>
        </div>
    </div>

    <div style="display: flex; gap: 15px; margin-top: 20px;">
        <a href="{{ route('santri.program.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <button type="submit" class="btn btn-success" style="flex: 1;">
            <i class="fas fa-save"></i> Simpan & Lanjutkan ke Pembayaran
        </button>
    </div>
</form>
@endsection
