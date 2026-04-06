@extends('layouts.ustad')

@section('title', 'Jadwal Wawancara')

@section('content')
<div class="page-header">
    <h1>Jadwal Wawancara</h1>
    <p>Daftar santri yang dijadwalkan untuk wawancara dengan Anda</p>
</div>

<div class="card" style="margin-bottom: 20px;">
    <div class="card-body">
        <form method="GET" style="display: flex; gap: 15px; flex-wrap: wrap;">
            <input type="date" name="date" class="form-control" style="max-width: 200px;" value="{{ request('date') }}">
            <button type="submit" class="btn btn-secondary"><i class="fas fa-filter"></i> Filter</button>
            <a href="{{ route('ustad.interview.index') }}" class="btn btn-secondary"><i class="fas fa-refresh"></i> Reset</a>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($schedules->count() > 0)
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Santri</th>
                            <th>No Telp</th>
                            <th>Program</th>
                            <th>Media</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schedules as $schedule)
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($schedule->schedule_date)->format('d M Y') }}
                                    @if($schedule->schedule_date == today()->format('Y-m-d'))
                                        <span class="badge badge-warning">Hari Ini</span>
                                    @endif
                                </td>
                                <td>{{ $schedule->schedule_time }}</td>
                                <td>
                                    <strong>{{ $schedule->registration->user->name }}</strong><br>
                                    <small style="color: #999;">{{ $schedule->registration->user->email }}</small>
                                </td>
                                <td>
                                    @if($schedule->programData && $schedule->programData->no_hp)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $schedule->programData->no_hp) }}" 
                                           target="_blank" 
                                           style="color: #28a745; text-decoration: none;">
                                            <i class="fab fa-whatsapp"></i> {{ $schedule->programData->no_hp }}
                                        </a>
                                    @else
                                        <span style="color: #999;">-</span>
                                    @endif
                                </td>
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
                                        <i class="fas fa-play"></i> Mulai Wawancara
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $schedules->links() }}
        @else
            <div style="text-align: center; padding: 50px; color: #999;">
                <i class="fas fa-calendar-check" style="font-size: 3rem; margin-bottom: 15px;"></i>
                <p>Tidak ada jadwal wawancara yang menunggu</p>
            </div>
        @endif
    </div>
</div>
@endsection
