@extends('layouts.santri')

@section('title', 'Pengumuman')

@section('content')
<div class="page-header">
    <h1>Pengumuman Kelulusan</h1>
    <p>Hasil kelulusan pendaftaran PPDB Maskanul Huffadz</p>
</div>

@if($decision)
    <div class="card" style="border: 3px solid {{ $decision->is_lulus ? 'var(--green-islamic)' : '#dc3545' }};">
        <div class="card-body" style="text-align: center; padding: 50px;">
            @if($decision->is_lulus)
                <div style="width: 100px; height: 100px; background: linear-gradient(135deg, var(--green-islamic), #2E7D32); border-radius: 50%; margin: 0 auto 25px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-check" style="font-size: 3rem; color: white;"></i>
                </div>
                <h2 style="color: var(--green-islamic); font-size: 2rem; margin-bottom: 15px;">🎉 SELAMAT, ANDA LULUS! 🎉</h2>
                <p style="color: #666; font-size: 1.1rem; max-width: 500px; margin: 0 auto 25px;">
                    Alhamdulillah, Anda dinyatakan <strong>LULUS</strong> seleksi PPDB Maskanul Huffadz program <strong>{{ $registration->program->name }}</strong>.
                </p>
            @else
                <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #dc3545, #c82333); border-radius: 50%; margin: 0 auto 25px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-times" style="font-size: 3rem; color: white;"></i>
                </div>
                <h2 style="color: #dc3545; font-size: 1.8rem; margin-bottom: 15px;">Mohon Maaf</h2>
                <p style="color: #666; font-size: 1.1rem; max-width: 500px; margin: 0 auto 25px;">
                    Dengan berat hati kami sampaikan bahwa Anda belum dapat diterima di program <strong>{{ $registration->program->name }}</strong> tahun ini.
                </p>
            @endif

            @if($decision->notes)
                <div style="background: var(--off-white); padding: 20px; border-radius: 12px; max-width: 500px; margin: 0 auto 25px;">
                    <strong>Catatan:</strong>
                    <p style="margin: 10px 0 0 0;">{{ $decision->notes }}</p>
                </div>
            @endif

            <p style="color: #999; font-size: 0.9rem;">
                Diumumkan pada: {{ $decision->decided_at ? $decision->decided_at->format('d M Y H:i') : '-' }}
            </p>

            @if($decision->is_lulus)
                <div style="margin-top: 30px;">
                    <a href="{{ route('santri.daftar-ulang') }}" class="btn btn-success btn-lg">
                        <i class="fas fa-redo"></i> Lanjut ke Daftar Ulang
                    </a>
                </div>
            @endif
        </div>
    </div>
@elseif($registration && $registration->interviewSchedule && $registration->interviewSchedule->status == 'completed')
    <div class="card">
        <div class="card-body" style="text-align: center; padding: 60px;">
            <i class="fas fa-hourglass-half" style="font-size: 3rem; color: #ffc107; margin-bottom: 20px;"></i>
            <h3 style="color: #666;">Menunggu Pengumuman</h3>
            <p style="color: #999; max-width: 400px; margin: 10px auto;">
                Wawancara Anda telah selesai. Silakan tunggu pengumuman kelulusan dari panitia.
            </p>
        </div>
    </div>
@else
    <div class="card">
        <div class="card-body" style="text-align: center; padding: 60px;">
            <i class="fas fa-bullhorn" style="font-size: 3rem; color: #ccc; margin-bottom: 20px;"></i>
            <h3 style="color: #666;">Belum Ada Pengumuman</h3>
            <p style="color: #999;">Pengumuman kelulusan akan ditampilkan setelah proses wawancara selesai.</p>
        </div>
    </div>
@endif
@endsection
