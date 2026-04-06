@extends('layouts.santri')

@section('title', 'Pendaftaran Selesai')

@section('content')
<div class="page-header">
    <h1>Status Pendaftaran</h1>
    <p>Informasi pendaftaran dan pembayaran Anda</p>
</div>

<div class="card">
    <div class="card-body" style="text-align: center; padding: 40px;">
        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #28a745, #20c997); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
            <i class="fas fa-check" style="font-size: 2.5rem; color: white;"></i>
        </div>
        <h2 style="color: #28a745; margin-bottom: 10px;">Pendaftaran & Pembayaran Berhasil!</h2>
        <p style="color: #666;">Anda telah menyelesaikan proses pendaftaran dan pembayaran.</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-file-alt"></i> Detail Pendaftaran</h3>
    </div>
    <div class="card-body">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
            <div style="padding: 15px; background: var(--off-white); border-radius: 10px;">
                <small style="color: #666;">Program</small>
                <p style="font-weight: 600; margin: 5px 0 0; color: var(--dark-gray);">{{ $registration->program->name }}</p>
            </div>
            <div style="padding: 15px; background: var(--off-white); border-radius: 10px;">
                <small style="color: #666;">Status Pendaftaran</small>
                <p style="font-weight: 600; margin: 5px 0 0; color: #28a745;">{{ ucfirst(str_replace('_', ' ', $registration->status)) }}</p>
            </div>
            <div style="padding: 15px; background: var(--off-white); border-radius: 10px;">
                <small style="color: #666;">Tanggal Daftar</small>
                <p style="font-weight: 600; margin: 5px 0 0; color: var(--dark-gray);">{{ $registration->created_at->format('d M Y') }}</p>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-credit-card"></i> Detail Pembayaran</h3>
    </div>
    <div class="card-body">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
            <div style="padding: 15px; background: var(--off-white); border-radius: 10px;">
                <small style="color: #666;">Status Pembayaran</small>
                <p style="margin: 5px 0 0;">
                    <span class="badge badge-success" style="font-size: 0.9rem;">
                        <i class="fas fa-check-circle"></i> Lunas
                    </span>
                </p>
            </div>
            @if($registration->payment)
            <div style="padding: 15px; background: var(--off-white); border-radius: 10px;">
                <small style="color: #666;">Jumlah Dibayar</small>
                <p style="font-weight: 600; margin: 5px 0 0; color: var(--primary-gold);">
                    Rp {{ number_format($registration->payment->amount ?? $registration->program->registration_fee ?? 0, 0, ',', '.') }}
                </p>
            </div>
            <div style="padding: 15px; background: var(--off-white); border-radius: 10px;">
                <small style="color: #666;">Tanggal Pembayaran</small>
                <p style="font-weight: 600; margin: 5px 0 0; color: var(--dark-gray);">
                    {{ $registration->payment->paid_at ? \Carbon\Carbon::parse($registration->payment->paid_at)->format('d M Y H:i') : $registration->updated_at->format('d M Y H:i') }}
                </p>
            </div>
            <div style="padding: 15px; background: var(--off-white); border-radius: 10px;">
                <small style="color: #666;">Metode Pembayaran</small>
                <p style="font-weight: 600; margin: 5px 0 0; color: var(--dark-gray);">
                    {{ ucfirst($registration->payment->payment_method ?? 'Transfer Bank') }}
                </p>
            </div>
            @else
            <div style="padding: 15px; background: var(--off-white); border-radius: 10px;">
                <small style="color: #666;">Biaya Pendaftaran</small>
                <p style="font-weight: 600; margin: 5px 0 0; color: var(--primary-gold);">
                    Rp {{ number_format($registration->program->registration_fee ?? 0, 0, ',', '.') }}
                </p>
            </div>
            @endif
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-info-circle"></i> Langkah Selanjutnya</h3>
    </div>
    <div class="card-body">
        <div style="display: flex; flex-direction: column; gap: 15px;">
            <div style="display: flex; align-items: center; gap: 15px; padding: 15px; background: rgba(40, 167, 69, 0.1); border-radius: 10px; border-left: 4px solid #28a745;">
                <i class="fas fa-check-circle" style="font-size: 1.5rem; color: #28a745;"></i>
                <div>
                    <strong>1. Pendaftaran & Pembayaran</strong>
                    <p style="margin: 0; color: #666; font-size: 0.9rem;">Selesai ✓</p>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 15px; padding: 15px; background: rgba(23, 162, 184, 0.1); border-radius: 10px; border-left: 4px solid #17a2b8;">
                <i class="fas fa-calendar-alt" style="font-size: 1.5rem; color: #17a2b8;"></i>
                <div>
                    <strong>2. Wawancara</strong>
                    <p style="margin: 0; color: #666; font-size: 0.9rem;">Tunggu jadwal wawancara dari panitia</p>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 15px; padding: 15px; background: rgba(184, 134, 11, 0.1); border-radius: 10px; border-left: 4px solid var(--primary-gold);">
                <i class="fas fa-bullhorn" style="font-size: 1.5rem; color: var(--primary-gold);"></i>
                <div>
                    <strong>3. Pengumuman</strong>
                    <p style="margin: 0; color: #666; font-size: 0.9rem;">Cek menu pengumuman untuk hasil kelulusan</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="display: flex; gap: 15px; margin-top: 20px;">
    <a href="{{ route('santri.biodata.index') }}" class="btn btn-secondary">
        <i class="fas fa-user"></i> Lihat Biodata
    </a>
    <a href="{{ route('santri.dashboard') }}" class="btn btn-success">
        <i class="fas fa-home"></i> Kembali ke Dashboard
    </a>
</div>
@endsection
