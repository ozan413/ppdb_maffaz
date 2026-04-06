@extends('layouts.admin')

@section('title', 'Edit Data Santri - ' . $user->name)

@section('content')
<div class="page-header">
    <div style="display: flex; align-items: center; gap: 15px;">
        <a href="{{ route('admin.kelola-santri.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1>Edit Data Santri</h1>
            <p>{{ $user->name }} - {{ $user->email }}</p>
        </div>
    </div>
</div>

<!-- Data Akun -->
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-user-circle"></i> Data Akun</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.kelola-santri.update-user', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-row">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                </div>
            </div>
            <div class="form-group">
                <label>Password Baru <small style="color: #999;">(Kosongkan jika tidak ingin mengubah)</small></label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password baru...">
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Data Akun
            </button>
        </form>
    </div>
</div>

@if($registration)
<!-- Status Registrasi -->
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-info-circle"></i> Status Registrasi</h3>
    </div>
    <div class="card-body">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px;">
            <div style="padding: 15px; background: var(--off-white); border-radius: 10px;">
                <small style="color: #666;">Program</small>
                <p style="font-weight: 600; margin: 5px 0 0;">{{ $registration->program->name }}</p>
            </div>
            <div style="padding: 15px; background: var(--off-white); border-radius: 10px;">
                <small style="color: #666;">Status</small>
                <p style="font-weight: 600; margin: 5px 0 0;">{{ ucfirst(str_replace('_', ' ', $registration->status)) }}</p>
            </div>
            <div style="padding: 15px; background: var(--off-white); border-radius: 10px;">
                <small style="color: #666;">Pembayaran</small>
                <p style="font-weight: 600; margin: 5px 0 0;">{{ ucfirst($registration->payment_status) }}</p>
            </div>
            <div style="padding: 15px; background: var(--off-white); border-radius: 10px;">
                <small style="color: #666;">Tanggal Daftar</small>
                <p style="font-weight: 600; margin: 5px 0 0;">{{ $registration->created_at->format('d M Y') }}</p>
            </div>
        </div>
    </div>
</div>
@endif

@if($programData)
<!-- Biodata Program -->
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-id-card"></i> Biodata Program ({{ ucfirst(str_replace('_', ' ', $programType)) }})</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.kelola-santri.update-biodata', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-row">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" value="{{ $programData->nama_lengkap ?? '' }}">
                </div>
                @if(isset($programData->nama_panggilan))
                <div class="form-group">
                    <label>Nama Panggilan</label>
                    <input type="text" name="nama_panggilan" class="form-control" value="{{ $programData->nama_panggilan ?? '' }}">
                </div>
                @endif
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="form-control" value="{{ $programData->tempat_lahir ?? '' }}">
                </div>
                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" value="{{ $programData->tanggal_lahir ? (is_string($programData->tanggal_lahir) ? $programData->tanggal_lahir : $programData->tanggal_lahir->format('Y-m-d')) : '' }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Usia</label>
                    <input type="number" name="usia" class="form-control" value="{{ $programData->usia ?? '' }}">
                </div>
                <div class="form-group">
                    <label>Gender</label>
                    <select name="gender" class="form-control">
                        <option value="">-- Pilih --</option>
                        <option value="Laki-Laki" {{ ($programData->gender ?? '') == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                        <option value="Perempuan" {{ ($programData->gender ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>No. HP</label>
                    <input type="text" name="no_hp" class="form-control" value="{{ $programData->no_hp ?? '' }}">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $programData->email ?? '' }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Provinsi Domisili</label>
                    <input type="text" name="provinsi_domisili" class="form-control" value="{{ $programData->provinsi_domisili ?? '' }}">
                </div>
                <div class="form-group">
                    <label>Kota/Kabupaten</label>
                    <input type="text" name="kota_kabupaten" class="form-control" value="{{ $programData->kota_kabupaten ?? '' }}">
                </div>
            </div>

            <div class="form-group">
                <label>Alamat Lengkap</label>
                <textarea name="domisili_lengkap" class="form-control" rows="2">{{ $programData->domisili_lengkap ?? '' }}</textarea>
            </div>

            @if(isset($programData->pendidikan_terakhir))
            <div class="form-group">
                <label>Pendidikan Terakhir</label>
                <input type="text" name="pendidikan_terakhir" class="form-control" value="{{ $programData->pendidikan_terakhir ?? '' }}">
            </div>
            @endif

            <div class="form-row">
                <div class="form-group">
                    <label>Nama Ayah</label>
                    <input type="text" name="nama_ayah" class="form-control" value="{{ $programData->nama_ayah ?? '' }}">
                </div>
                <div class="form-group">
                    <label>Nama Ibu</label>
                    <input type="text" name="nama_ibu" class="form-control" value="{{ $programData->nama_ibu ?? '' }}">
                </div>
            </div>

            @if(isset($programData->pekerjaan_ayah))
            <div class="form-row">
                <div class="form-group">
                    <label>Pekerjaan Ayah</label>
                    <input type="text" name="pekerjaan_ayah" class="form-control" value="{{ $programData->pekerjaan_ayah ?? '' }}">
                </div>
                <div class="form-group">
                    <label>Pekerjaan Ibu</label>
                    <input type="text" name="pekerjaan_ibu" class="form-control" value="{{ $programData->pekerjaan_ibu ?? '' }}">
                </div>
            </div>
            @endif

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Biodata
            </button>
        </form>
    </div>
</div>
@else
<div class="card">
    <div class="card-body" style="text-align: center; padding: 40px; color: #999;">
        <i class="fas fa-file-alt" style="font-size: 2rem; margin-bottom: 10px;"></i>
        <p>Biodata program belum diisi oleh santri.</p>
    </div>
</div>
@endif

@if($daftarUlang)
<!-- Data Daftar Ulang -->
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-clipboard-check"></i> Data Daftar Ulang ({{ ucfirst(str_replace('_', ' ', $daftarUlangType)) }})</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.kelola-santri.update-daftar-ulang', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            @if(isset($daftarUlang->nik))
            <div class="form-row">
                <div class="form-group">
                    <label>NIK</label>
                    <input type="text" name="nik" class="form-control" value="{{ $daftarUlang->nik }}" maxlength="16">
                </div>
                @if(isset($daftarUlang->nisn))
                <div class="form-group">
                    <label>NISN</label>
                    <input type="text" name="nisn" class="form-control" value="{{ $daftarUlang->nisn }}" maxlength="10">
                </div>
                @endif
            </div>
            @endif

            @if(isset($daftarUlang->jalur_program))
            <div class="form-group">
                <label>Jalur Program</label>
                <select name="jalur_program" class="form-control">
                    <option value="Beasiswa Dhuafa" {{ $daftarUlang->jalur_program == 'Beasiswa Dhuafa' ? 'selected' : '' }}>Beasiswa Dhuafa</option>
                    <option value="Beasiswa Dhuafa Yatim" {{ $daftarUlang->jalur_program == 'Beasiswa Dhuafa Yatim' ? 'selected' : '' }}>Beasiswa Dhuafa Yatim</option>
                    <option value="Beasiswa Dhuafa Piatu" {{ $daftarUlang->jalur_program == 'Beasiswa Dhuafa Piatu' ? 'selected' : '' }}>Beasiswa Dhuafa Piatu</option>
                    <option value="Beasiswa Dhuafa Muallaf" {{ $daftarUlang->jalur_program == 'Beasiswa Dhuafa Muallaf' ? 'selected' : '' }}>Beasiswa Dhuafa Muallaf</option>
                    <option value="Beasiswa Dhuafa Prestasi" {{ $daftarUlang->jalur_program == 'Beasiswa Dhuafa Prestasi' ? 'selected' : '' }}>Beasiswa Dhuafa Prestasi</option>
                    <option value="Reguler/Berbayar" {{ $daftarUlang->jalur_program == 'Reguler/Berbayar' ? 'selected' : '' }}>Reguler/Berbayar</option>
                </select>
            </div>
            @endif

            <div class="form-row">
                @if(isset($daftarUlang->jumlah_saudara))
                <div class="form-group">
                    <label>Jumlah Saudara</label>
                    <input type="number" name="jumlah_saudara" class="form-control" value="{{ $daftarUlang->jumlah_saudara }}" min="1" max="10">
                </div>
                @endif
                @if(isset($daftarUlang->ukuran_jubah))
                <div class="form-group">
                    <label>Ukuran Jubah</label>
                    <input type="text" name="ukuran_jubah" class="form-control" value="{{ $daftarUlang->ukuran_jubah }}">
                </div>
                @endif
            </div>

            @if(isset($daftarUlang->anak_ke))
            <div class="form-group">
                <label>Anak Ke</label>
                <input type="number" name="anak_ke" class="form-control" value="{{ $daftarUlang->anak_ke }}" min="1" max="10">
            </div>
            @endif

            <div class="form-group">
                <label>Alamat Orang Tua/Wali</label>
                <textarea name="alamat_ortu_wali" class="form-control" rows="2">{{ $daftarUlang->alamat_ortu_wali ?? '' }}</textarea>
            </div>

            @if(isset($daftarUlang->status_rumah))
            <div class="form-row">
                <div class="form-group">
                    <label>Status Rumah</label>
                    <select name="status_rumah" class="form-control">
                        <option value="Milik Orang Tua" {{ $daftarUlang->status_rumah == 'Milik Orang Tua' ? 'selected' : '' }}>Milik Orang Tua</option>
                        <option value="Milik Pribadi" {{ $daftarUlang->status_rumah == 'Milik Pribadi' ? 'selected' : '' }}>Milik Pribadi</option>
                        <option value="Rumah Dinas" {{ $daftarUlang->status_rumah == 'Rumah Dinas' ? 'selected' : '' }}>Rumah Dinas</option>
                        <option value="Kontrakan/Sewa" {{ $daftarUlang->status_rumah == 'Kontrakan/Sewa' ? 'selected' : '' }}>Kontrakan/Sewa</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Kondisi Rumah</label>
                    <select name="kondisi_rumah" class="form-control">
                        <option value="Gubuk" {{ $daftarUlang->kondisi_rumah == 'Gubuk' ? 'selected' : '' }}>Gubuk</option>
                        <option value="Permanen" {{ $daftarUlang->kondisi_rumah == 'Permanen' ? 'selected' : '' }}>Permanen</option>
                        <option value="Semi Permanen" {{ $daftarUlang->kondisi_rumah == 'Semi Permanen' ? 'selected' : '' }}>Semi Permanen</option>
                    </select>
                </div>
            </div>
            @endif

            @if(isset($daftarUlang->pengalaman_menghafal))
            <div class="form-row">
                <div class="form-group">
                    <label>Pengalaman Menghafal</label>
                    <select name="pengalaman_menghafal" class="form-control">
                        <option value="Pernah" {{ $daftarUlang->pengalaman_menghafal == 'Pernah' ? 'selected' : '' }}>Pernah</option>
                        <option value="Belum" {{ $daftarUlang->pengalaman_menghafal == 'Belum' ? 'selected' : '' }}>Belum</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Jumlah Hafalan (Juz)</label>
                    <input type="number" name="jumlah_hafalan_juz" class="form-control" value="{{ $daftarUlang->jumlah_hafalan_juz }}" min="0" max="30">
                </div>
            </div>
            @endif

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Data Daftar Ulang
            </button>
        </form>
    </div>
</div>
@else
<div class="card">
    <div class="card-body" style="text-align: center; padding: 40px; color: #999;">
        <i class="fas fa-clipboard" style="font-size: 2rem; margin-bottom: 10px;"></i>
        <p>Data daftar ulang belum diisi atau santri belum dinyatakan lulus.</p>
    </div>
</div>
@endif

@endsection
