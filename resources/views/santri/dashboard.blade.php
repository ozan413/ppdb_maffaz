@extends('layouts.santri')

@section('title', 'Dashboard')

@section('content')
<div class="welcome-card">
    <h2>Assalamu'alaikum, {{ $user->name }}! 👋</h2>
    <p>Selamat datang di Portal Pendaftaran PPDB Maskanul Huffadz. Silakan lengkapi data pendaftaran Anda.</p>
</div>

<div class="status-cards">
    <div class="status-card">
        <h3>Status Pendaftaran</h3>
        @if($registration)
            @switch($registration->status)
                @case('draft')
                    <span class="badge badge-warning">Draft</span>
                    @break
                @case('submitted')
                    <span class="badge badge-info">Menunggu Pembayaran</span>
                    @break
                @case('paid')
                    <span class="badge badge-success">Telah Bayar</span>
                    @break
                @case('interview_scheduled')
                    <span class="badge badge-primary">Wawancara Terjadwal</span>
                    @break
                @case('interviewed')
                    <span class="badge badge-info">Telah Wawancara</span>
                    @break
                @case('passed')
                    <span class="badge badge-success">Lulus</span>
                    @break
                @case('failed')
                    <span class="badge badge-danger">Tidak Lulus</span>
                    @break
                @default
                    <span class="badge badge-secondary">{{ $registration->status }}</span>
            @endswitch
        @else
            <span class="badge badge-warning">Belum Mendaftar</span>
        @endif
    </div>

    <div class="status-card">
        <h3>Program Dipilih</h3>
        <div class="value">
            @if($registration && $registration->program)
                {{ $registration->program->name }}
            @else
                Belum memilih program
            @endif
        </div>
    </div>

    <div class="status-card">
        <h3>Status Pembayaran</h3>
        @if($registration)
            @if($registration->payment_status === 'paid')
                <span class="badge badge-success">Lunas</span>
            @elseif($registration->payment_status === 'pending')
                <span class="badge badge-warning">Belum Bayar</span>
            @else
                <span class="badge badge-danger">{{ ucfirst($registration->payment_status) }}</span>
            @endif
        @else
            <span class="badge badge-secondary">-</span>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-tasks"></i> Langkah Pendaftaran</h3>
    </div>
    <div class="card-body">
        <div class="steps-container" style="display: flex; gap: 20px; flex-wrap: wrap;">
            <!-- Step 1 -->
            <div class="step-item" style="flex: 1; min-width: 200px; padding: 20px; border-radius: 12px; background: {{ $registration && $registration->is_program_locked ? 'rgba(27, 94, 32, 0.1)' : 'var(--off-white)' }}; text-align: center;">
                <div style="width: 50px; height: 50px; border-radius: 50%; background: {{ $registration && $registration->is_program_locked ? 'linear-gradient(135deg, var(--green-islamic), #2E7D32)' : 'var(--light-gray)' }}; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center; color: {{ $registration && $registration->is_program_locked ? 'white' : 'var(--dark-gray)' }};">
                    <i class="fas {{ $registration && $registration->is_program_locked ? 'fa-check' : 'fa-clipboard-list' }}"></i>
                </div>
                <h4 style="margin-bottom: 5px; font-size: 0.95rem;">1. Pilih Program</h4>
                <p style="font-size: 0.8rem; color: #666;">Pilih program dan isi formulir</p>
            </div>

            <!-- Step 2 -->
            <div class="step-item" style="flex: 1; min-width: 200px; padding: 20px; border-radius: 12px; background: {{ $registration && $registration->payment_status === 'paid' ? 'rgba(27, 94, 32, 0.1)' : 'var(--off-white)' }}; text-align: center;">
                <div style="width: 50px; height: 50px; border-radius: 50%; background: {{ $registration && $registration->payment_status === 'paid' ? 'linear-gradient(135deg, var(--green-islamic), #2E7D32)' : 'var(--light-gray)' }}; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center; color: {{ $registration && $registration->payment_status === 'paid' ? 'white' : 'var(--dark-gray)' }};">
                    <i class="fas {{ $registration && $registration->payment_status === 'paid' ? 'fa-check' : 'fa-credit-card' }}"></i>
                </div>
                <h4 style="margin-bottom: 5px; font-size: 0.95rem;">2. Pembayaran</h4>
                <p style="font-size: 0.8rem; color: #666;">Bayar biaya pendaftaran</p>
            </div>

            <!-- Step 3 -->
            <div class="step-item" style="flex: 1; min-width: 200px; padding: 20px; border-radius: 12px; background: {{ $registration && $registration->interviewSchedule ? 'rgba(27, 94, 32, 0.1)' : 'var(--off-white)' }}; text-align: center;">
                <div style="width: 50px; height: 50px; border-radius: 50%; background: {{ $registration && $registration->interviewSchedule && $registration->interviewSchedule->status === 'completed' ? 'linear-gradient(135deg, var(--green-islamic), #2E7D32)' : 'var(--light-gray)' }}; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center; color: {{ $registration && $registration->interviewSchedule && $registration->interviewSchedule->status === 'completed' ? 'white' : 'var(--dark-gray)' }};">
                    <i class="fas {{ $registration && $registration->interviewSchedule && $registration->interviewSchedule->status === 'completed' ? 'fa-check' : 'fa-comments' }}"></i>
                </div>
                <h4 style="margin-bottom: 5px; font-size: 0.95rem;">3. Wawancara</h4>
                <p style="font-size: 0.8rem; color: #666;">Ikuti sesi wawancara</p>
            </div>

            <!-- Step 4 -->
            <div class="step-item" style="flex: 1; min-width: 200px; padding: 20px; border-radius: 12px; background: {{ $registration && $registration->graduationDecision ? 'rgba(27, 94, 32, 0.1)' : 'var(--off-white)' }}; text-align: center;">
                <div style="width: 50px; height: 50px; border-radius: 50%; background: {{ $registration && $registration->graduationDecision && $registration->graduationDecision->is_lulus ? 'linear-gradient(135deg, var(--green-islamic), #2E7D32)' : 'var(--light-gray)' }}; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center; color: {{ $registration && $registration->graduationDecision ? 'white' : 'var(--dark-gray)' }};">
                    <i class="fas {{ $registration && $registration->graduationDecision && $registration->graduationDecision->is_lulus ? 'fa-check' : 'fa-trophy' }}"></i>
                </div>
                <h4 style="margin-bottom: 5px; font-size: 0.95rem;">4. Pengumuman</h4>
                <p style="font-size: 0.8rem; color: #666;">Lihat hasil kelulusan</p>
            </div>
        </div>

        <div style="margin-top: 30px; text-align: center;">
            @if(!$registration)
                <a href="{{ route('santri.program.index') }}" class="btn btn-success btn-lg">
                    <i class="fas fa-plus"></i> Mulai Pendaftaran
                </a>
            @elseif(!$registration->is_program_locked)
                <a href="{{ route('santri.program.index') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-edit"></i> Lanjutkan Pendaftaran
                </a>
            @elseif($registration->payment_status !== 'paid')
                <a href="{{ route('santri.payment.index') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-credit-card"></i> Lanjutkan ke Pembayaran
                </a>
            @else
                <a href="{{ route('santri.biodata.index') }}" class="btn btn-secondary btn-lg">
                    <i class="fas fa-user"></i> Lihat Biodata
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
