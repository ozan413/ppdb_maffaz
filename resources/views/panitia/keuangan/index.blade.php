@extends('layouts.panitia')

@section('title', 'Keuangan')

@section('content')
<div class="page-header">
    <h1>Data Keuangan PPDB</h1>
    <p>Rekap pembayaran pendaftaran santri</p>
</div>

<!-- Statistics Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div class="card" style="background: linear-gradient(135deg, #28a745, #20c997);">
        <div class="card-body" style="color: white; text-align: center; padding: 25px;">
            <i class="fas fa-check-circle" style="font-size: 2rem; margin-bottom: 10px;"></i>
            <h2 style="margin: 0; font-size: 2rem;">{{ $stats['total_paid'] }}</h2>
            <p style="margin: 5px 0 0; opacity: 0.9;">Sudah Bayar</p>
        </div>
    </div>
    <div class="card" style="background: linear-gradient(135deg, #ffc107, #fd7e14);">
        <div class="card-body" style="color: white; text-align: center; padding: 25px;">
            <i class="fas fa-clock" style="font-size: 2rem; margin-bottom: 10px;"></i>
            <h2 style="margin: 0; font-size: 2rem;">{{ $stats['total_pending'] }}</h2>
            <p style="margin: 5px 0 0; opacity: 0.9;">Menunggu Bayar</p>
        </div>
    </div>
    <div class="card" style="background: linear-gradient(135deg, #1565C0, #1976D2);">
        <div class="card-body" style="color: white; text-align: center; padding: 25px;">
            <i class="fas fa-money-bill-wave" style="font-size: 2rem; margin-bottom: 10px;"></i>
            <h2 style="margin: 0; font-size: 1.5rem;">Rp {{ number_format($stats['total_amount'], 0, ',', '.') }}</h2>
            <p style="margin: 5px 0 0; opacity: 0.9;">Total Penerimaan</p>
        </div>
    </div>
    <div class="card" style="background: linear-gradient(135deg, #00695c, #26a69a);">
        <div class="card-body" style="color: white; text-align: center; padding: 25px;">
            <i class="fas fa-calendar-alt" style="font-size: 2rem; margin-bottom: 10px;"></i>
            <h2 style="margin: 0; font-size: 1.5rem;">Rp {{ number_format($stats['this_month'], 0, ',', '.') }}</h2>
            <p style="margin: 5px 0 0; opacity: 0.9;">Bulan Ini</p>
        </div>
    </div>
</div>

<!-- Payment by Program -->
@if($paymentByProgram->count() > 0)
<div class="card" style="margin-bottom: 20px;">
    <div class="card-header">
        <h3><i class="fas fa-chart-pie"></i> Pembayaran Per Program</h3>
    </div>
    <div class="card-body">
        <div style="display: flex; gap: 20px; flex-wrap: wrap;">
            @foreach($paymentByProgram as $item)
                <div style="background: var(--off-white); padding: 15px 25px; border-radius: 10px; text-align: center; min-width: 150px;">
                    <p style="margin: 0 0 5px; font-weight: 600; color: var(--teal);">{{ $item->program->name ?? 'Program' }}</p>
                    <span style="font-size: 1.5rem; font-weight: 700; color: var(--dark-gray);">{{ $item->count }}</span>
                    <small style="display: block; color: #666;">santri</small>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Filter -->
<div class="card" style="margin-bottom: 20px;">
    <div class="card-body">
        <form method="GET" style="display: flex; gap: 15px; flex-wrap: wrap; align-items: flex-end;">
            <div style="flex: 1; min-width: 200px;">
                <label style="font-size: 0.85rem; color: #666;">Cari</label>
                <input type="text" name="search" class="form-control" placeholder="Nama atau email..." value="{{ request('search') }}">
            </div>
            <div style="min-width: 150px;">
                <label style="font-size: 0.85rem; color: #666;">Program</label>
                <select name="program_id" class="form-control">
                    <option value="">Semua</option>
                    @foreach($programs as $program)
                        <option value="{{ $program->id }}" {{ request('program_id') == $program->id ? 'selected' : '' }}>{{ $program->name }}</option>
                    @endforeach
                </select>
            </div>
            <div style="min-width: 140px;">
                <label style="font-size: 0.85rem; color: #666;">Dari Tanggal</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div style="min-width: 140px;">
                <label style="font-size: 0.85rem; color: #666;">Sampai Tanggal</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <button type="submit" class="btn btn-teal">
                <i class="fas fa-filter"></i> Filter
            </button>
            <a href="{{ route('panitia.keuangan.index') }}" class="btn btn-secondary">
                <i class="fas fa-undo"></i> Reset
            </a>
        </form>
    </div>
</div>

<!-- Payment Table -->
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-list"></i> Daftar Pembayaran</h3>
        <span class="badge badge-success">{{ $payments->total() }} data</span>
    </div>
    <div class="card-body">
        @if($payments->count() > 0)
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Santri</th>
                            <th>Program</th>
                            <th>Jumlah Bayar</th>
                            <th>Tanggal Bayar</th>
                            <th>Metode</th>
                            <th style="text-align: center;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $index => $reg)
                            <tr>
                                <td>{{ $payments->firstItem() + $index }}</td>
                                <td>
                                    <strong>{{ $reg->user->name }}</strong>
                                    <br><small style="color: #666;">{{ $reg->user->email }}</small>
                                </td>
                                <td>
                                    <span class="badge badge-primary">{{ $reg->program->name }}</span>
                                </td>
                                <td style="font-weight: 600; color: var(--teal);">
                                    Rp {{ number_format($reg->payment->amount ?? $reg->program->registration_fee ?? 0, 0, ',', '.') }}
                                </td>
                                <td>
                                    @if($reg->payment && $reg->payment->paid_at)
                                        {{ \Carbon\Carbon::parse($reg->payment->paid_at)->format('d M Y') }}
                                        <br><small style="color: #666;">{{ \Carbon\Carbon::parse($reg->payment->paid_at)->format('H:i') }}</small>
                                    @else
                                        {{ $reg->updated_at->format('d M Y') }}
                                    @endif
                                </td>
                                <td>
                                    {{ ucfirst($reg->payment->payment_method ?? 'Transfer') }}
                                </td>
                                <td style="text-align: center;">
                                    <span class="badge badge-success">
                                        <i class="fas fa-check-circle"></i> Lunas
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 20px;">
                {{ $payments->appends(request()->query())->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 60px; color: #999;">
                <i class="fas fa-receipt" style="font-size: 3rem; margin-bottom: 20px;"></i>
                <h3 style="color: #666;">Belum Ada Data Pembayaran</h3>
                <p>Data pembayaran santri akan muncul di sini.</p>
            </div>
        @endif
    </div>
</div>
@endsection
