@extends('layouts.santri')

@section('title', 'Formulir PaudQu')

@section('content')
<div class="page-header">
    <h1>Formulir Pendaftaran - PaudQu</h1>
    <p>Lengkapi data berikut untuk mendaftar program PaudQu</p>
</div>

<form action="{{ route('santri.program.store', 'paudqu') }}" method="POST">
    @csrf

    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-list"></i> Pilihan Program</h3>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group">
                    <label>Program Pilihan <span style="color: red;">*</span></label>
                    <select name="program_pilihan" class="form-control @error('program_pilihan') is-invalid @enderror" required>
                        <option value="">-- Pilih Program --</option>
                        <option value="PaudQu Reguler" {{ old('program_pilihan', $data->program_pilihan ?? '') == 'PaudQu Reguler' ? 'selected' : '' }}>PaudQu Reguler</option>
                        <option value="PaudQu Fullday" {{ old('program_pilihan', $data->program_pilihan ?? '') == 'PaudQu Fullday' ? 'selected' : '' }}>PaudQu Fullday</option>
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
            <div class="form-group">
                <label>Durasi Program <span style="color: red;">*</span></label>
                <select name="durasi_program" class="form-control" required>
                    <option value="">-- Pilih Durasi --</option>
                    <option value="1 Tahun" {{ old('durasi_program', $data->durasi_program ?? '') == '1 Tahun' ? 'selected' : '' }}>1 Tahun</option>
                    <option value="2 Tahun" {{ old('durasi_program', $data->durasi_program ?? '') == '2 Tahun' ? 'selected' : '' }}>2 Tahun</option>
                </select>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-baby"></i> Data Anak</h3>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label>Nama Lengkap Anak <span style="color: red;">*</span></label>
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
                    <input type="text" name="usia" class="form-control @error('usia') is-invalid @enderror" value="{{ old('usia', $data->usia ?? '') }}" placeholder="Contoh: 4 Tahun 6 Bulan" required>
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

            <div class="form-group">
                <label>Email Pendaftar <span style="color: red;">*</span></label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $data->email ?? '') }}" placeholder="contoh: email@example.com" required>
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
                    <label>Kabupaten/Kota <span style="color: red;">*</span></label>
                    <input type="text" name="kota_kabupaten" class="form-control" value="{{ old('kota_kabupaten', $data->kota_kabupaten ?? '') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label>Alamat Lengkap Domisili <span style="color: red;">*</span></label>
                <textarea name="domisili_lengkap" class="form-control" rows="3" required>{{ old('domisili_lengkap', $data->domisili_lengkap ?? '') }}</textarea>
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
                    <option value="">-- Pilih Sumber Informasi --</option>
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
                    <label>Nomor Telepon Ayah <span style="color: red;">*</span></label>
                    <input type="text" name="no_telepon_ayah" class="form-control" value="{{ old('no_telepon_ayah', $data->no_telepon_ayah ?? '') }}" placeholder="Contoh: 08123456789" required>
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
                    <label>Nomor Telepon Ibu <span style="color: red;">*</span></label>
                    <input type="text" name="no_telepon_ibu" class="form-control" value="{{ old('no_telepon_ibu', $data->no_telepon_ibu ?? '') }}" placeholder="Contoh: 08123456789" required>
                </div>
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
