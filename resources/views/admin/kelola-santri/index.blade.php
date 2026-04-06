@extends('layouts.admin')

@section('title', 'Kelola Santri')

@section('content')
<div class="page-header">
    <h1>Kelola Data Santri</h1>
    <p>Edit data akun, biodata program, dan daftar ulang santri</p>
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
            <button type="submit" class="btn btn-secondary"><i class="fas fa-filter"></i> Filter</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-users"></i> Daftar Santri</h3>
        <span class="badge badge-info">{{ $santris->total() }} santri</span>
    </div>
    <div class="card-body">
        @if($santris->count() > 0)
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Program</th>
                            <th>Status</th>
                            <th>Data</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($santris as $index => $santri)
                            <tr>
                                <td>{{ $santris->firstItem() + $index }}</td>
                                <td><strong>{{ $santri->name }}</strong></td>
                                <td>{{ $santri->email }}</td>
                                <td>
                                    @if($santri->registration)
                                        <span class="badge badge-primary">{{ $santri->registration->program->name ?? '-' }}</span>
                                    @else
                                        <span style="color: #999;">Belum pilih</span>
                                    @endif
                                </td>
                                <td>
                                    @if($santri->registration)
                                        @switch($santri->registration->status)
                                            @case('passed')
                                                <span class="badge badge-success">Lulus</span>
                                                @break
                                            @case('failed')
                                                <span class="badge badge-danger">Tidak Lulus</span>
                                                @break
                                            @case('re_registered')
                                                <span class="badge badge-info">Daftar Ulang</span>
                                                @break
                                            @default
                                                <span class="badge badge-secondary">{{ ucfirst(str_replace('_', ' ', $santri->registration->status)) }}</span>
                                        @endswitch
                                    @else
                                        <span class="badge badge-secondary">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($santri->registration)
                                        @php
                                            $hasProgram = $santri->registration->getProgramData() ? '✅' : '❌';
                                            $hasDaftar = false;
                                            if($santri->registration->graduationDecision?->is_lulus) {
                                                $hasDaftar = \App\Models\DaftarUlangLilAthfal::where('registration_id', $santri->registration->id)->exists() ||
                                                            \App\Models\DaftarUlangIddahTahfidz::where('registration_id', $santri->registration->id)->exists() ||
                                                            \App\Models\DaftarUlangPaudqu::where('registration_id', $santri->registration->id)->exists();
                                            }
                                        @endphp
                                        <small>
                                            Biodata: {{ $hasProgram }}<br>
                                            D.Ulang: {{ $hasDaftar ? '✅' : '❌' }}
                                        </small>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <a href="{{ route('admin.kelola-santri.show', $santri->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> Detail/Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 20px;">
                {{ $santris->appends(request()->query())->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 60px; color: #999;">
                <i class="fas fa-users-slash" style="font-size: 3rem; margin-bottom: 20px;"></i>
                <h3 style="color: #666;">Belum Ada Data Santri</h3>
                <p>Santri yang terdaftar akan muncul di sini.</p>
            </div>
        @endif
    </div>
</div>
@endsection
