@extends('layouts.santri')

@section('title', 'Pembayaran')

@section('content')
<div class="page-header">
    <h1>Pembayaran Pendaftaran</h1>
    <p>Lakukan pembayaran untuk menyelesaikan proses pendaftaran</p>
</div>

@if($payment && $payment->status === 'success')
    <div class="card" style="border: 2px solid var(--green-islamic);">
        <div class="card-body" style="text-align: center; padding: 50px;">
            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--green-islamic), #2E7D32); border-radius: 50%; margin: 0 auto 25px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-check" style="font-size: 2.5rem; color: white;"></i>
            </div>
            <h2 style="color: var(--green-islamic); margin-bottom: 10px;">Pembayaran Berhasil!</h2>
            <p style="color: #666; margin-bottom: 20px;">Terima kasih, pembayaran Anda telah berhasil dikonfirmasi.</p>
            
            <div style="background: var(--off-white); padding: 20px; border-radius: 15px; margin-bottom: 25px; max-width: 400px; margin-left: auto; margin-right: auto;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span style="color: #666;">Order ID:</span>
                    <strong>{{ $payment->order_id }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span style="color: #666;">Jumlah:</span>
                    <strong style="color: var(--primary-gold);">Rp {{ number_format($payment->amount, 0, ',', '.') }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: #666;">Tanggal Bayar:</span>
                    <strong>{{ $payment->paid_at->format('d M Y H:i') }}</strong>
                </div>
            </div>

            <p style="color: #888; font-size: 0.9rem;">Silakan tunggu informasi jadwal wawancara yang akan diumumkan melalui sistem.</p>
            
            <a href="{{ route('santri.dashboard') }}" class="btn btn-success" style="margin-top: 15px;">
                <i class="fas fa-home"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
@else
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-info-circle"></i> Detail Pembayaran</h3>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
                <div style="background: var(--off-white); padding: 20px; border-radius: 12px;">
                    <h4 style="color: #666; font-size: 0.85rem; margin-bottom: 8px;">Program</h4>
                    <div style="font-size: 1.1rem; font-weight: 600; color: var(--black);">
                        {{ $registration->program->name }}
                    </div>
                </div>
                <div style="background: var(--off-white); padding: 20px; border-radius: 12px;">
                    <h4 style="color: #666; font-size: 0.85rem; margin-bottom: 8px;">Biaya Pendaftaran</h4>
                    <div style="font-size: 1.3rem; font-weight: 700; color: var(--primary-gold);">
                        Rp {{ number_format($registration->program->price, 0, ',', '.') }}
                    </div>
                </div>
                <div style="background: var(--off-white); padding: 20px; border-radius: 12px;">
                    <h4 style="color: #666; font-size: 0.85rem; margin-bottom: 8px;">Status Pembayaran</h4>
                    <span class="badge badge-warning" style="font-size: 0.9rem;">Belum Dibayar</span>
                </div>
            </div>

            @if($registration->program->price > 0)
                <form action="{{ route('santri.payment.create') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">
                        <i class="fas fa-credit-card"></i> Bayar Sekarang
                    </button>
                </form>

                <p style="text-align: center; margin-top: 20px; color: #888; font-size: 0.85rem;">
                    Pembayaran akan diproses melalui Midtrans Payment Gateway.<br>
                    Anda dapat menggunakan berbagai metode pembayaran seperti Bank Transfer, E-Wallet, dll.
                </p>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    Program ini tidak memiliki biaya pendaftaran. Silakan hubungi admin untuk informasi lebih lanjut.
                </div>
            @endif
        </div>
    </div>
@endif
@endsection
