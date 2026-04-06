@extends('layouts.panitia')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1>Dashboard Panitia</h1>
    <p>Selamat datang di panel panitia PPDB Maskanul Huffadz</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-icon"><i class="fas fa-user-check"></i></div>
        <h3>{{ $stats['total_paid'] }}</h3>
        <p>Total Pendaftar Lunas</p>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon"><i class="fas fa-clock"></i></div>
        <h3>{{ $stats['awaiting_schedule'] }}</h3>
        <p>Belum Dijadwalkan</p>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon"><i class="fas fa-calendar-check"></i></div>
        <h3>{{ $stats['scheduled'] }}</h3>
        <p>Terjadwal</p>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon"><i class="fas fa-check-double"></i></div>
        <h3>{{ $stats['completed'] }}</h3>
        <p>Wawancara Selesai</p>
    </div>
</div>

<div class="stats-grid" style="grid-template-columns: repeat(3, 1fr);">
    <div class="stat-card" style="border-left: 4px solid #ffc107;">
        <h3>{{ $stats['awaiting_decision'] }}</h3>
        <p>Menunggu Keputusan</p>
    </div>
    <div class="stat-card" style="border-left: 4px solid #28a745;">
        <h3>{{ $stats['passed'] }}</h3>
        <p>Lulus</p>
    </div>
    <div class="stat-card" style="border-left: 4px solid #dc3545;">
        <h3>{{ $stats['failed'] }}</h3>
        <p>Tidak Lulus</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-history"></i> Pendaftar Terbaru (Lunas)</h3>
        <a href="{{ route('panitia.pendaftar.index') }}" class="btn btn-sm btn-secondary">Lihat Semua</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Program</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentRegistrations as $reg)
                        <tr>
                            <td>{{ $reg->user->name }}</td>
                            <td>{{ $reg->program->name ?? '-' }}</td>
                            <td>
                                @switch($reg->status)
                                    @case('paid')<span class="badge badge-success">Lunas</span>@break
                                    @case('interview_scheduled')<span class="badge badge-info">Terjadwal</span>@break
                                    @case('interviewed')<span class="badge badge-primary">Sudah Wawancara</span>@break
                                    @case('passed')<span class="badge badge-success">Lulus</span>@break
                                    @case('failed')<span class="badge badge-danger">Tidak Lulus</span>@break
                                    @default<span class="badge badge-warning">{{ $reg->status }}</span>
                                @endswitch
                            </td>
                            <td>{{ $reg->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('panitia.pendaftar.show', $reg->id) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" style="text-align: center; color: #999;">Belum ada pendaftar</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
