@extends('layouts.santri')

@section('title', 'Daftar Ulang Selesai')

@section('content')
<div class="page-header">
    <h1>Daftar Ulang Selesai</h1>
    <p>Anda telah menyelesaikan proses daftar ulang</p>
</div>

<div class="card">
    <div class="card-body" style="text-align: center; padding: 60px;">
        <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #2E7D32, #4CAF50); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px;">
            <i class="fas fa-check" style="font-size: 3rem; color: white;"></i>
        </div>
        
        <h2 style="color: #2E7D32; margin-bottom: 15px;">Selamat!</h2>
        <p style="font-size: 1.1rem; color: #666; margin-bottom: 30px;">
            Data daftar ulang Anda untuk program <strong>{{ $registration->program->name }}</strong> telah berhasil disimpan.
        </p>

        <div style="background: var(--off-white); padding: 25px; border-radius: 15px; text-align: left; max-width: 500px; margin: 0 auto;">
            <h4 style="margin-bottom: 15px; color: var(--dark-green);"><i class="fas fa-info-circle"></i> Langkah Selanjutnya</h4>
            <ul style="padding-left: 20px; color: #666; line-height: 1.8;">
                <li>Tunggu konfirmasi dari pihak pesantren</li>
                <li>Siapkan dokumen asli untuk verifikasi</li>
                <li>Pantau email dan nomor telepon Anda</li>
            </ul>
        </div>

        <div style="margin-top: 30px;">
            <a href="{{ route('santri.dashboard') }}" class="btn btn-primary">
                <i class="fas fa-home"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>

<!-- Data Summary -->
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-file-alt"></i> Ringkasan Data Daftar Ulang</h3>
    </div>
    <div class="card-body">
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 15px;">
            @if(isset($existingData->nik))
                <div>
                    <label style="color: #666; font-size: 0.85rem;">NIK</label>
                    <p style="font-weight: 500;">{{ $existingData->nik }}</p>
                </div>
            @endif
            
            @if(isset($existingData->nisn))
                <div>
                    <label style="color: #666; font-size: 0.85rem;">NISN</label>
                    <p style="font-weight: 500;">{{ $existingData->nisn }}</p>
                </div>
            @endif

            @if(isset($existingData->jalur_program))
                <div>
                    <label style="color: #666; font-size: 0.85rem;">Jalur Program</label>
                    <p style="font-weight: 500;">{{ $existingData->jalur_program }}</p>
                </div>
            @endif

            @if(isset($existingData->jumlah_saudara))
                <div>
                    <label style="color: #666; font-size: 0.85rem;">Jumlah Saudara</label>
                    <p style="font-weight: 500;">{{ $existingData->jumlah_saudara }}</p>
                </div>
            @endif

            @if(isset($existingData->ukuran_jubah))
                <div>
                    <label style="color: #666; font-size: 0.85rem;">Ukuran Jubah</label>
                    <p style="font-weight: 500;">{{ $existingData->ukuran_jubah }}</p>
                </div>
            @endif

            @if(isset($existingData->alamat_ortu_wali))
                <div style="grid-column: 1 / -1;">
                    <label style="color: #666; font-size: 0.85rem;">Alamat Orang Tua/Wali</label>
                    <p style="font-weight: 500;">{{ $existingData->alamat_ortu_wali }}</p>
                </div>
            @endif
        </div>

        <p style="color: #999; font-size: 0.85rem; margin-top: 20px; text-align: center;">
            <i class="fas fa-clock"></i> Disubmit pada: {{ $existingData->created_at->format('d M Y H:i') }}
        </p>
    </div>
</div>
@endsection
