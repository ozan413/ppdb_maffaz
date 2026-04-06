@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1>Dashboard Admin</h1>
    <p>Selamat datang di panel administrator PPDB Maskanul Huffadz</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-card-icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
        <h3>{{ $stats['total_santri'] }}</h3>
        <p>Total Santri Terdaftar</p>
    </div>

    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-card-icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
        </div>
        <h3>{{ $stats['total_registrations'] }}</h3>
        <p>Total Pendaftaran</p>
    </div>

    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-card-icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
        <h3>{{ $stats['paid_registrations'] }}</h3>
        <p>Sudah Bayar</p>
    </div>

    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-card-icon">
                <i class="fas fa-clock"></i>
            </div>
        </div>
        <h3>{{ $stats['pending_registrations'] }}</h3>
        <p>Menunggu Pembayaran</p>
    </div>
</div>

<div class="stats-grid" style="grid-template-columns: repeat(2, 1fr);">
    <div class="stat-card" style="background: {{ $stats['ppdb_status'] ? 'linear-gradient(135deg, #28a745, #20c997)' : 'linear-gradient(135deg, #dc3545, #c82333)' }}; color: white;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3 style="font-size: 1.5rem;">{{ $stats['ppdb_status'] ? 'PPDB DIBUKA' : 'PPDB DITUTUP' }}</h3>
                <p style="opacity: 0.9;">Status Pendaftaran</p>
            </div>
            <div style="font-size: 3rem; opacity: 0.5;">
                <i class="fas {{ $stats['ppdb_status'] ? 'fa-door-open' : 'fa-door-closed' }}"></i>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3>{{ $stats['total_programs'] }}</h3>
                <p>Program Tersedia</p>
            </div>
            <div class="stat-card-icon">
                <i class="fas fa-book"></i>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-history"></i> Pendaftaran Terbaru</h3>
        <a href="#" class="btn btn-sm btn-secondary">Lihat Semua</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Program</th>
                        <th>Status</th>
                        <th>Pembayaran</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentRegistrations as $reg)
                        <tr>
                            <td>{{ $reg->user->name }}</td>
                            <td>{{ $reg->user->email }}</td>
                            <td>{{ $reg->program->name ?? '-' }}</td>
                            <td>
                                @switch($reg->status)
                                    @case('draft')
                                        <span class="badge badge-warning">Draft</span>
                                        @break
                                    @case('submitted')
                                        <span class="badge badge-info">Submitted</span>
                                        @break
                                    @case('paid')
                                        <span class="badge badge-success">Paid</span>
                                        @break
                                    @case('passed')
                                        <span class="badge badge-success">Lulus</span>
                                        @break
                                    @case('failed')
                                        <span class="badge badge-danger">Tidak Lulus</span>
                                        @break
                                    @default
                                        <span class="badge badge-secondary">{{ $reg->status }}</span>
                                @endswitch
                            </td>
                            <td>
                                @if($reg->payment_status === 'paid')
                                    <span class="badge badge-success">Lunas</span>
                                @else
                                    <span class="badge badge-warning">Pending</span>
                                @endif
                            </td>
                            <td>{{ $reg->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: #999;">Belum ada pendaftaran</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
