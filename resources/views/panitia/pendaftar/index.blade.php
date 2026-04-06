@extends('layouts.panitia')

@section('title', 'Data Pendaftar')

@section('content')
<div class="page-header">
    <h1>Data Pendaftar</h1>
    <p>Daftar santri yang telah menyelesaikan pembayaran</p>
</div>

<div class="card" style="margin-bottom: 20px;">
    <div class="card-body">
        <form method="GET" style="display: flex; gap: 15px; flex-wrap: wrap;">
            <input type="text" name="search" class="form-control" style="max-width: 250px;" placeholder="Cari nama atau email..." value="{{ request('search') }}">
            <select name="program_id" class="form-control" style="max-width: 200px;">
                <option value="">Semua Program</option>
                @foreach($programs as $program)
                    <option value="{{ $program->id }}" {{ request('program_id') == $program->id ? 'selected' : '' }}>{{ $program->name }}</option>
                @endforeach
            </select>
            <select name="status" class="form-control" style="max-width: 180px;">
                <option value="">Semua Status</option>
                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Lunas</option>
                <option value="interview_scheduled" {{ request('status') == 'interview_scheduled' ? 'selected' : '' }}>Terjadwal</option>
                <option value="interviewed" {{ request('status') == 'interviewed' ? 'selected' : '' }}>Sudah Wawancara</option>
                <option value="passed" {{ request('status') == 'passed' ? 'selected' : '' }}>Lulus</option>
                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Tidak Lulus</option>
            </select>
            <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i> Cari</button>
            <a href="{{ route('panitia.pendaftar.index') }}" class="btn btn-secondary"><i class="fas fa-refresh"></i></a>
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
                            <th>Nama</th>
                            <th>Program</th>
                            <th>Status</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registrations as $reg)
                            <tr>
                                <td>
                                    <strong>{{ $reg->user->name }}</strong><br>
                                    <small style="color: #999;">{{ $reg->user->email }}</small>
                                </td>
                                <td>{{ $reg->program->name ?? '-' }}</td>
                                <td>
                                    @switch($reg->status)
                                        @case('paid')<span class="badge badge-success">Lunas</span>@break
                                        @case('interview_scheduled')<span class="badge badge-info">Terjadwal</span>@break
                                        @case('interviewed')<span class="badge badge-primary">Sudah Wawancara</span>@break
                                        @case('passed')<span class="badge badge-success">Lulus</span>@break
                                        @case('failed')<span class="badge badge-danger">Tidak Lulus</span>@break
                                        @default<span class="badge badge-secondary">{{ $reg->status }}</span>
                                    @endswitch
                                </td>
                                <td>{{ $reg->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('panitia.pendaftar.show', $reg->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 20px;">
                {{ $registrations->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 50px; color: #999;">
                <i class="fas fa-users" style="font-size: 3rem; margin-bottom: 15px;"></i>
                <p>Belum ada pendaftar yang lunas</p>
            </div>
        @endif
    </div>
</div>
@endsection
