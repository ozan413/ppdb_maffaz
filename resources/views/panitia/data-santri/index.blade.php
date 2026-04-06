@extends('layouts.panitia')

@section('title', 'Data Santri')

@section('content')
<div class="page-header">
    <h1>Data Santri</h1>
    <p>Lihat data lengkap santri dan download PDF</p>
</div>

<div class="card" style="margin-bottom: 20px;">
    <div class="card-body">
        <form method="GET" style="display: flex; gap: 15px; flex-wrap: wrap; align-items: center;">
            <input type="text" name="search" class="form-control" placeholder="Cari nama atau email..." value="{{ request('search') }}" style="max-width: 250px;">
            <select name="program_id" class="form-control" style="max-width: 200px;">
                <option value="">Semua Program</option>
                @foreach($programs as $program)
                    <option value="{{ $program->id }}" {{ request('program_id') == $program->id ? 'selected' : '' }}>{{ $program->name }}</option>
                @endforeach
            </select>
            <select name="status" class="form-control" style="max-width: 200px;">
                <option value="">Semua Status</option>
                <option value="passed" {{ request('status') == 'passed' ? 'selected' : '' }}>Lulus</option>
                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Tidak Lulus</option>
                <option value="re_registered" {{ request('status') == 're_registered' ? 'selected' : '' }}>Sudah Daftar Ulang</option>
            </select>
            <button type="submit" class="btn btn-secondary"><i class="fas fa-filter"></i> Filter</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($registrations->count() > 0)
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Santri</th>
                            <th>Program</th>
                            <th>Status</th>
                            <th>Tanggal Daftar</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registrations as $index => $reg)
                            <tr>
                                <td>{{ $registrations->firstItem() + $index }}</td>
                                <td>
                                    <strong>{{ $reg->user->name }}</strong><br>
                                    <small style="color: #999;">{{ $reg->user->email }}</small>
                                </td>
                                <td>{{ $reg->program->name }}</td>
                                <td>
                                    @switch($reg->status)
                                        @case('passed')
                                            <span class="badge badge-success">Lulus</span>
                                            @break
                                        @case('failed')
                                            <span class="badge badge-danger">Tidak Lulus</span>
                                            @break
                                        @case('re_registered')
                                            <span class="badge badge-info">Daftar Ulang</span>
                                            @break
                                        @case('interviewed')
                                            <span class="badge badge-warning">Sudah Wawancara</span>
                                            @break
                                        @default
                                            <span class="badge badge-secondary">{{ ucfirst($reg->status) }}</span>
                                    @endswitch
                                </td>
                                <td>{{ $reg->created_at->format('d M Y') }}</td>
                                <td style="text-align: center;">
                                    <a href="{{ route('panitia.data-santri.pdf-template', $reg->id) }}" class="btn btn-sm btn-danger" title="Download PDF">
                                        <i class="fas fa-file-pdf"></i> Download PDF
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 20px;">
                {{ $registrations->appends(request()->query())->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 60px; color: #999;">
                <i class="fas fa-users-slash" style="font-size: 3rem; margin-bottom: 20px;"></i>
                <h3 style="color: #666;">Belum Ada Data Santri</h3>
                <p>Data santri yang sudah membayar akan muncul di sini.</p>
            </div>
        @endif
    </div>
</div>
@endsection
