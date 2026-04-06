@extends('layouts.panitia')

@section('title', 'Detail Pendaftar')

@section('content')
<div class="page-header">
    <h1>Detail Pendaftar</h1>
    <p>Informasi lengkap pendaftaran {{ $registration->user->name }}</p>
</div>

<div style="display: grid; grid-template-columns: 1fr 350px; gap: 20px;">
    <div>
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-user"></i> Data Pribadi</h3>
            </div>
            <div class="card-body">
                @if($programData)
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                        <div>
                            <label style="color: #666; font-size: 0.85rem;">Nama Lengkap</label>
                            <p style="font-weight: 500;">{{ $programData->nama_lengkap }}</p>
                        </div>
                        <div>
                            <label style="color: #666; font-size: 0.85rem;">Gender</label>
                            <p style="font-weight: 500;">{{ $programData->gender }}</p>
                        </div>
                        <div>
                            <label style="color: #666; font-size: 0.85rem;">TTL</label>
                            <p style="font-weight: 500;">{{ $programData->tempat_lahir }}, {{ $programData->tanggal_lahir }}</p>
                        </div>
                        <div>
                            <label style="color: #666; font-size: 0.85rem;">Usia</label>
                            <p style="font-weight: 500;">{{ $programData->usia }} tahun</p>
                        </div>
                    </div>

                    <hr style="margin: 20px 0;">

                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                        <div>
                            <label style="color: #666; font-size: 0.85rem;">Provinsi</label>
                            <p style="font-weight: 500;">{{ $programData->provinsi_domisili }}</p>
                        </div>
                        <div>
                            <label style="color: #666; font-size: 0.85rem;">Kota</label>
                            <p style="font-weight: 500;">{{ $programData->kota_kabupaten }}</p>
                        </div>
                    </div>
                    <div style="margin-top: 15px;">
                        <label style="color: #666; font-size: 0.85rem;">Alamat Lengkap</label>
                        <p style="font-weight: 500;">{{ $programData->domisili_lengkap }}</p>
                    </div>

                    <hr style="margin: 20px 0;">

                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                        <div>
                            <label style="color: #666; font-size: 0.85rem;">Nama Ayah</label>
                            <p style="font-weight: 500;">{{ $programData->nama_ayah }}</p>
                        </div>
                        <div>
                            <label style="color: #666; font-size: 0.85rem;">Nama Ibu</label>
                            <p style="font-weight: 500;">{{ $programData->nama_ibu }}</p>
                        </div>
                    </div>
                @else
                    <p style="color: #999; text-align: center;">Data pendaftaran tidak tersedia</p>
                @endif
            </div>
        </div>
    </div>

    <div>
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-info-circle"></i> Status</h3>
            </div>
            <div class="card-body">
                <div style="margin-bottom: 20px;">
                    <label style="color: #666; font-size: 0.85rem;">Program</label>
                    <p style="font-weight: 600; font-size: 1.1rem;">{{ $registration->program->name }}</p>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="color: #666; font-size: 0.85rem;">Status Pendaftaran</label><br>
                    @switch($registration->status)
                        @case('paid')<span class="badge badge-success">Lunas</span>@break
                        @case('interview_scheduled')<span class="badge badge-info">Wawancara Terjadwal</span>@break
                        @case('interviewed')<span class="badge badge-primary">Sudah Wawancara</span>@break
                        @case('passed')<span class="badge badge-success">Lulus</span>@break
                        @case('failed')<span class="badge badge-danger">Tidak Lulus</span>@break
                        @default<span class="badge badge-secondary">{{ $registration->status }}</span>
                    @endswitch
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="color: #666; font-size: 0.85rem;">Pembayaran</label><br>
                    @if($registration->payment_status === 'paid')
                        <span class="badge badge-success">Lunas</span>
                        @if($registration->payment)
                            <p style="margin-top: 5px; font-size: 0.9rem;">
                                Rp {{ number_format($registration->payment->amount, 0, ',', '.') }}<br>
                                <small style="color: #999;">{{ $registration->payment->paid_at ? $registration->payment->paid_at->format('d M Y H:i') : '-' }}</small>
                            </p>
                        @endif
                    @else
                        <span class="badge badge-warning">Pending</span>
                    @endif
                </div>

                @if($registration->interviewSchedule)
                    <div style="margin-bottom: 20px;">
                        <label style="color: #666; font-size: 0.85rem;">Jadwal Wawancara</label>
                        <p style="font-weight: 500;">
                            {{ \Carbon\Carbon::parse($registration->interviewSchedule->schedule_date)->format('d M Y') }} - {{ $registration->interviewSchedule->schedule_time }}<br>
                            <small style="color: #666;">Ustad: {{ $registration->interviewSchedule->ustad->name ?? '-' }}</small>
                        </p>
                    </div>
                @endif

                @if($registration->interviewSchedule && $registration->interviewSchedule->result)
                    <div style="margin-bottom: 20px;">
                        <label style="color: #666; font-size: 0.85rem;">Nilai Akademik</label>
                        <p style="font-weight: 600; font-size: 1.3rem; color: #1565C0;">
                            {{ $registration->interviewSchedule->result->nilai_akademik }}
                        </p>
                        <small style="color: #666;">
                            Tahfidz: {{ $registration->interviewSchedule->result->nilai_tahfidz ?? 0 }} |
                            Tahsin: {{ $registration->interviewSchedule->result->nilai_tahsin ?? 0 }} |
                            B. Arab: {{ $registration->interviewSchedule->result->nilai_bahasa_arab ?? 0 }} |
                            Tajwid: {{ $registration->interviewSchedule->result->nilai_tajwid ?? 0 }}
                        </small>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="color: #666; font-size: 0.85rem;">Nilai Wawancara</label><br>
                        <span class="badge" style="font-size: 1.2rem; padding: 8px 20px;
                            @switch($registration->interviewSchedule->result->nilai_wawancara)
                                @case('A') background: rgba(40, 167, 69, 0.15); color: #28a745; @break
                                @case('B') background: rgba(23, 162, 184, 0.15); color: #17a2b8; @break
                                @case('C') background: rgba(255, 193, 7, 0.15); color: #856404; @break
                                @case('D') background: rgba(220, 53, 69, 0.15); color: #dc3545; @break
                                @default background: #f0f0f0; color: #999; @break
                            @endswitch
                        ">{{ $registration->interviewSchedule->result->nilai_wawancara }}</span>
                    </div>
                @endif

                <div>
                    <label style="color: #666; font-size: 0.85rem;">Tanggal Daftar</label>
                    <p style="font-weight: 500;">{{ $registration->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>

        <a href="{{ route('panitia.pendaftar.index') }}" class="btn btn-secondary" style="width: 100%; margin-top: 15px;">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection
