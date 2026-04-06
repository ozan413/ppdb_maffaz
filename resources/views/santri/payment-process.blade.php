@extends('layouts.santri')

@section('title', 'Proses Pembayaran')

@push('styles')
<style>
    .payment-container {
        max-width: 600px;
        margin: 0 auto;
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <h1>Proses Pembayaran</h1>
    <p>Menyelesaikan pembayaran untuk program {{ $registration->program->name }}</p>
</div>

<div class="payment-container">
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-credit-card"></i> Detail Pembayaran</h3>
        </div>
        <div class="card-body" style="text-align: center;">
            <div style="background: var(--off-white); padding: 20px; border-radius: 12px; margin-bottom: 25px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span style="color: #666;">Order ID:</span>
                    <strong>{{ $payment->order_id }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span style="color: #666;">Program:</span>
                    <strong>{{ $registration->program->name }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: #666;">Jumlah:</span>
                    <strong style="color: var(--primary-gold); font-size: 1.2rem;">Rp {{ number_format($payment->amount, 0, ',', '.') }}</strong>
                </div>
            </div>

            <button id="pay-button" class="btn btn-primary btn-lg" style="width: 100%;">
                <i class="fas fa-credit-card"></i> Bayar Sekarang
            </button>

            <p style="margin-top: 20px; color: #888; font-size: 0.85rem;">
                Klik tombol di atas untuk membuka halaman pembayaran Midtrans.<br>
                Anda dapat memilih berbagai metode pembayaran yang tersedia.
            </p>

            <a href="{{ route('santri.payment.index') }}" class="btn btn-secondary" style="margin-top: 10px;">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function(){
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                window.location.href = '{{ route('santri.payment.index') }}';
            },
            onPending: function(result) {
                alert('Pembayaran pending. Silakan selesaikan pembayaran sesuai instruksi.');
                window.location.href = '{{ route('santri.payment.index') }}';
            },
            onError: function(result) {
                alert('Pembayaran gagal. Silakan coba lagi.');
                window.location.href = '{{ route('santri.payment.index') }}';
            },
            onClose: function() {
                alert('Anda menutup popup pembayaran. Silakan coba lagi.');
            }
        });
    };
</script>
@endpush
