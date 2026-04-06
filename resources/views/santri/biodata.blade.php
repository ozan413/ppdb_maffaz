@extends('layouts.santri')

@section('title', 'Biodata')

@section('content')
<div class="page-header">
    <h1>Biodata Pendaftaran</h1>
    <p>Data pendaftaran Anda untuk program {{ $registration->program->name ?? '-' }}</p>
</div>

@if(session('success'))
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

@if($canEdit)
<div class="alert alert-warning">
    <i class="fas fa-exclamation-triangle"></i>
    <strong>Belum Lunas!</strong> Data masih bisa diedit. Setelah pembayaran, data tidak dapat diubah.
    <a href="{{ route('santri.program.form', $registration->program->slug) }}" class="btn btn-sm btn-primary" style="margin-left: 15px;">
        <i class="fas fa-edit"></i> Edit Data Pendaftaran
    </a>
</div>
@else
<div class="alert alert-info">
    <i class="fas fa-lock"></i>
    Data tidak dapat diubah setelah pembayaran berhasil.
</div>
@endif

@if($data)
    <!-- Data Program -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-list"></i> Pilihan Program</h3>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                @if(isset($data->program_pilihan))
                <div>
                    <label style="color: #666; font-size: 0.85rem;">Program Pilihan</label>
                    <p style="font-weight: 500;">{{ $data->program_pilihan }}</p>
                </div>
                @endif
                @if(isset($data->jalur_program))
                <div>
                    <label style="color: #666; font-size: 0.85rem;">Jalur Program</label>
                    <p style="font-weight: 500;">{{ $data->jalur_program }}</p>
                </div>
                @endif
                @if(isset($data->jalur_masuk_program))
                <div>
                    <label style="color: #666; font-size: 0.85rem;">Jalur Masuk</label>
                    <p style="font-weight: 500;">{{ $data->jalur_masuk_program }}</p>
                </div>
                @endif
                @if(isset($data->durasi_program))
                <div>
                    <label style="color: #666; font-size: 0.85rem;">Durasi Program</label>
                    <p style="font-weight: 500;">{{ $data->durasi_program }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Data Pribadi -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-user"></i> Data Pribadi</h3>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                <div>
                    <label style="color: #666; font-size: 0.85rem;">Nama Lengkap</label>
                    <p style="font-weight: 500;">{{ $data->nama_lengkap }}</p>
                </div>
                <div>
                    <label style="color: #666; font-size: 0.85rem;">Tempat, Tanggal Lahir</label>
                    <p style="font-weight: 500;">{{ $data->tempat_lahir }}, {{ \Carbon\Carbon::parse($data->tanggal_lahir)->format('d M Y') }}</p>
                </div>
                <div>
                    <label style="color: #666; font-size: 0.85rem;">Usia</label>
                    <p style="font-weight: 500;">{{ $data->usia }}</p>
                </div>
                <div>
                    <label style="color: #666; font-size: 0.85rem;">Jenis Kelamin</label>
                    <p style="font-weight: 500;">{{ $data->gender }}</p>
                </div>
                @if(isset($data->pendidikan_terakhir))
                <div>
                    <label style="color: #666; font-size: 0.85rem;">Pendidikan Terakhir</label>
                    <p style="font-weight: 500;">{{ $data->pendidikan_terakhir }}</p>
                </div>
                @endif
                @if(isset($data->pemahaman_tajwid))
                <div>
                    <label style="color: #666; font-size: 0.85rem;">Pemahaman Tajwid</label>
                    <p style="font-weight: 500;">{{ $data->pemahaman_tajwid }}</p>
                </div>
                @endif
                @if(isset($data->email))
                <div>
                    <label style="color: #666; font-size: 0.85rem;">Email</label>
                    <p style="font-weight: 500;">{{ $data->email }}</p>
                </div>
                @endif
                @if(isset($data->no_hp))
                <div>
                    <label style="color: #666; font-size: 0.85rem;">Nomor HP/WA</label>
                    <p style="font-weight: 500;">{{ $data->no_hp }}</p>
                </div>
                @endif
            </div>
            @if(isset($data->riwayat_pendidikan_nonformal) && $data->riwayat_pendidikan_nonformal)
            <div style="margin-top: 15px;">
                <label style="color: #666; font-size: 0.85rem;">Riwayat Pendidikan Non Formal</label>
                <p style="font-weight: 500;">{{ $data->riwayat_pendidikan_nonformal }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Data Alamat -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-map-marker-alt"></i> Alamat Domisili</h3>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                <div>
                    <label style="color: #666; font-size: 0.85rem;">Provinsi</label>
                    <p style="font-weight: 500;">{{ $data->provinsi_domisili }}</p>
                </div>
                <div>
                    <label style="color: #666; font-size: 0.85rem;">Kota/Kabupaten</label>
                    <p style="font-weight: 500;">{{ $data->kota_kabupaten }}</p>
                </div>
            </div>
            <div style="margin-top: 15px;">
                <label style="color: #666; font-size: 0.85rem;">Alamat Lengkap</label>
                <p style="font-weight: 500;">{{ $data->domisili_lengkap }}</p>
            </div>
        </div>
    </div>

    <!-- Sumber Informasi -->
    @if(isset($data->sumber_informasi))
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-info-circle"></i> Sumber Informasi</h3>
        </div>
        <div class="card-body">
            <div>
                <label style="color: #666; font-size: 0.85rem;">Sumber Informasi PSB</label>
                <p style="font-weight: 500;">{{ $data->sumber_informasi }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Data Ayah -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-male"></i> Data Ayah</h3>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                <div>
                    <label style="color: #666; font-size: 0.85rem;">Nama Ayah</label>
                    <p style="font-weight: 500;">{{ $data->nama_ayah }}</p>
                </div>
                @if(isset($data->no_telepon_ayah))
                <div>
                    <label style="color: #666; font-size: 0.85rem;">Nomor Telepon Ayah</label>
                    <p style="font-weight: 500;">{{ $data->no_telepon_ayah }}</p>
                </div>
                @endif
                @if(isset($data->pekerjaan_ayah))
                <div>
                    <label style="color: #666; font-size: 0.85rem;">Pekerjaan Ayah</label>
                    <p style="font-weight: 500;">{{ $data->pekerjaan_ayah }}</p>
                </div>
                @endif
                @if(isset($data->penghasilan_ayah))
                <div>
                    <label style="color: #666; font-size: 0.85rem;">Penghasilan Ayah</label>
                    <p style="font-weight: 500;">{{ $data->penghasilan_ayah }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Data Ibu -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-female"></i> Data Ibu</h3>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                <div>
                    <label style="color: #666; font-size: 0.85rem;">Nama Ibu</label>
                    <p style="font-weight: 500;">{{ $data->nama_ibu }}</p>
                </div>
                @if(isset($data->no_telepon_ibu))
                <div>
                    <label style="color: #666; font-size: 0.85rem;">Nomor Telepon Ibu</label>
                    <p style="font-weight: 500;">{{ $data->no_telepon_ibu }}</p>
                </div>
                @endif
                @if(isset($data->pekerjaan_ibu))
                <div>
                    <label style="color: #666; font-size: 0.85rem;">Pekerjaan Ibu</label>
                    <p style="font-weight: 500;">{{ $data->pekerjaan_ibu }}</p>
                </div>
                @endif
                @if(isset($data->penghasilan_ibu))
                <div>
                    <label style="color: #666; font-size: 0.85rem;">Penghasilan Ibu</label>
                    <p style="font-weight: 500;">{{ $data->penghasilan_ibu }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Data Wali (jika ada) -->
    @if(isset($data->nama_wali) && $data->nama_wali)
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-user-shield"></i> Data Wali</h3>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                <div>
                    <label style="color: #666; font-size: 0.85rem;">Nama Wali</label>
                    <p style="font-weight: 500;">{{ $data->nama_wali }}</p>
                </div>
                @if(isset($data->no_telepon_wali))
                <div>
                    <label style="color: #666; font-size: 0.85rem;">Nomor Telepon Wali</label>
                    <p style="font-weight: 500;">{{ $data->no_telepon_wali }}</p>
                </div>
                @endif
                @if(isset($data->pekerjaan_wali))
                <div>
                    <label style="color: #666; font-size: 0.85rem;">Pekerjaan Wali</label>
                    <p style="font-weight: 500;">{{ $data->pekerjaan_wali }}</p>
                </div>
                @endif
                @if(isset($data->penghasilan_wali))
                <div>
                    <label style="color: #666; font-size: 0.85rem;">Penghasilan Wali</label>
                    <p style="font-weight: 500;">{{ $data->penghasilan_wali }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- Alamat Orang Tua/Wali -->
    @if(isset($data->alamat_ortu_wali))
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-home"></i> Alamat Orang Tua/Wali</h3>
        </div>
        <div class="card-body">
            <p style="font-weight: 500;">{{ $data->alamat_ortu_wali }}</p>
        </div>
    </div>
    @endif

    <!-- Tombol Aksi -->
    @if($canEdit)
    <div style="display: flex; gap: 15px; margin-top: 20px;">
        <a href="{{ route('santri.program.form', $registration->program->slug) }}" class="btn btn-primary" style="flex: 1;">
            <i class="fas fa-edit"></i> Edit Data Pendaftaran
        </a>
        <a href="{{ route('santri.payment.index') }}" class="btn btn-success">
            <i class="fas fa-credit-card"></i> Lanjut ke Pembayaran
        </a>
    </div>
    @endif

@else
    <div class="card">
        <div class="card-body" style="text-align: center; padding: 50px;">
            <i class="fas fa-file-alt" style="font-size: 3rem; color: #ccc; margin-bottom: 20px;"></i>
            <h3 style="color: #666;">Belum Ada Data Biodata</h3>
            <p style="color: #999; margin-bottom: 20px;">Anda belum mengisi formulir biodata untuk program {{ $registration->program->name ?? '-' }}.</p>
            <a href="{{ route('santri.program.index') }}" class="btn btn-success">
                <i class="fas fa-edit"></i> Lengkapi Biodata Sekarang
            </a>
        </div>
    </div>
@endif
@endsection
