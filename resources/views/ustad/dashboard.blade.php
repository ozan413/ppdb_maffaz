@extends('layouts.ustad')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1>Dashboard Ustad</h1>
    <p>Assalamu'alaikum, selamat datang di panel ustad</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-icon"><i class="fas fa-calendar-day"></i></div>
        <h3>{{ $stats['today'] }}</h3>
        <p>Wawancara Hari Ini</p>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon"><i class="fas fa-clock"></i></div>
        <h3>{{ $stats['total_scheduled'] }}</h3>
        <p>Menunggu Wawancara</p>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon"><i class="fas fa-check-double"></i></div>
        <h3>{{ $stats['completed'] }}</h3>
        <p>Wawancara Selesai</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-calendar-alt"></i> Jadwal Wawancara Mendatang</h3>
        <a href="{{ route('ustad.interview.index') }}" class="btn btn-sm btn-teal">Lihat Semua</a>
    </div>
    <div class="card-body">
        @if($upcomingSchedules->count() > 0)
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Nama Santri</th>
                            <th>Program</th>
                            <th>Media</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($upcomingSchedules as $schedule)
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($schedule->schedule_date)->format('d M Y') }}
                                    @if($schedule->schedule_date == today()->format('Y-m-d'))
                                        <span class="badge badge-warning">Hari Ini</span>
                                    @endif
                                </td>
                                <td>{{ $schedule->schedule_time }}</td>
                                <td>{{ $schedule->registration->user->name }}</td>
                                <td>{{ $schedule->registration->program->name }}</td>
                                <td>
                                    @switch($schedule->media)
                                        @case('whatsapp')<span class="badge badge-success">WhatsApp</span>@break
                                        @case('video_call')<span class="badge badge-info">Video Call</span>@break
                                        @case('tatap_muka')<span class="badge badge-primary">Tatap Muka</span>@break
                                    @endswitch
                                </td>
                                <td>
                                    <a href="{{ route('ustad.interview.show', $schedule->id) }}" class="btn btn-sm btn-teal">
                                        <i class="fas fa-play"></i> Mulai
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 40px; color: #999;">
                <i class="fas fa-calendar-times" style="font-size: 3rem; margin-bottom: 15px;"></i>
                <p>Tidak ada jadwal wawancara mendatang</p>
            </div>
        @endif
    </div>
</div>
@endsection
