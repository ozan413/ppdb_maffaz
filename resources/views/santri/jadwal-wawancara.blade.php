@extends('layouts.santri')

@section('title', 'Jadwal Wawancara')

@section('content')
<div class="page-header">
    <h1>Jadwal Wawancara</h1>
    <p>Informasi jadwal wawancara Anda</p>
</div>

@if($schedule)
    <div class="card" style="border: 2px solid var(--green-islamic);">
        <div class="card-body" style="padding: 30px;">
            <div style="text-align: center; margin-bottom: 30px;">
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--green-islamic), #2E7D32); border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-calendar-check" style="font-size: 2rem; color: white;"></i>
                </div>
                <h2 style="color: var(--green-islamic); margin-bottom: 10px;">Wawancara Terjadwal</h2>
                <p style="color: #666;">Silakan persiapkan diri Anda untuk wawancara</p>
            </div>

            <div style="background: var(--off-white); padding: 25px; border-radius: 15px;">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 25px;">
                    <div style="text-align: center;">
                        <i class="fas fa-calendar" style="font-size: 1.5rem; color: var(--primary-gold); margin-bottom: 10px;"></i>
                        <p style="color: #666; font-size: 0.85rem; margin-bottom: 5px;">Tanggal</p>
                        <strong style="font-size: 1.2rem;">{{ \Carbon\Carbon::parse($schedule->schedule_date)->format('d M Y') }}</strong>
                        @if($schedule->schedule_date == today()->format('Y-m-d'))
                            <span class="badge badge-warning" style="display: block; margin-top: 5px;">Hari Ini</span>
                        @endif
                    </div>
                    <div style="text-align: center;">
                        <i class="fas fa-clock" style="font-size: 1.5rem; color: var(--primary-gold); margin-bottom: 10px;"></i>
                        <p style="color: #666; font-size: 0.85rem; margin-bottom: 5px;">Waktu</p>
                        <strong style="font-size: 1.2rem;">{{ $schedule->schedule_time }}</strong>
                    </div>
                    <div style="text-align: center;">
                        <i class="fas fa-video" style="font-size: 1.5rem; color: var(--primary-gold); margin-bottom: 10px;"></i>
                        <p style="color: #666; font-size: 0.85rem; margin-bottom: 5px;">Media</p>
                        <strong style="font-size: 1.2rem;">
                            @switch($schedule->media)
                                @case('whatsapp') WhatsApp @break
                                @case('video_call') Video Call @break
                                @case('tatap_muka') Tatap Muka @break
                            @endswitch
                        </strong>
                    </div>
                    <div style="text-align: center;">
                        <i class="fas fa-user-tie" style="font-size: 1.5rem; color: var(--primary-gold); margin-bottom: 10px;"></i>
                        <p style="color: #666; font-size: 0.85rem; margin-bottom: 5px;">Pewawancara</p>
                        <strong style="font-size: 1.2rem;">{{ $schedule->ustad->name ?? 'TBA' }}</strong>
                    </div>
                </div>
            </div>

            @if($schedule->notes)
                <div style="margin-top: 20px; padding: 15px; background: rgba(184, 134, 11, 0.1); border-radius: 10px;">
                    <strong><i class="fas fa-info-circle"></i> Catatan:</strong>
                    <p style="margin: 5px 0 0 0;">{{ $schedule->notes }}</p>
                </div>
            @endif

            @if($schedule->status == 'completed')
                <div style="margin-top: 25px; text-align: center;">
                    <span class="badge badge-success" style="font-size: 1rem; padding: 10px 20px;">
                        <i class="fas fa-check-circle"></i> Wawancara Selesai
                    </span>
                    @if($schedule->result)
                        <p style="margin-top: 15px; color: #666;">
                            Nilai Total: <strong style="font-size: 1.2rem; color: var(--green-islamic);">{{ $schedule->result->nilai_total }}</strong>
                        </p>
                    @endif
                </div>
            @endif
        </div>
    </div>
@else
    <div class="card">
        <div class="card-body" style="text-align: center; padding: 60px;">
            <i class="fas fa-calendar-times" style="font-size: 3rem; color: #ccc; margin-bottom: 20px;"></i>
            <h3 style="color: #666;">Belum Ada Jadwal</h3>
            <p style="color: #999;">Jadwal wawancara Anda belum ditentukan. Silakan tunggu informasi dari panitia.</p>
        </div>
    </div>
@endif
@endsection
