@extends('layouts.admin')

@section('title', 'Kelola Program')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1>Kelola Program</h1>
        <p>Daftar program pendidikan yang tersedia</p>
    </div>
    <a href="{{ route('admin.programs.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Program
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Nama Program</th>
                        <th>Slug</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Pendaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($programs as $program)
                        <tr>
                            <td><strong>{{ $program->name }}</strong></td>
                            <td><code>{{ $program->slug }}</code></td>
                            <td>Rp {{ number_format($program->price, 0, ',', '.') }}</td>
                            <td>
                                @if($program->is_active)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Nonaktif</span>
                                @endif
                            </td>
                            <td>{{ $program->registrations_count ?? $program->registrations()->count() }}</td>
                            <td>
                                <a href="{{ route('admin.programs.edit', $program) }}" class="btn btn-sm btn-secondary"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.programs.destroy', $program) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus program ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: #999;">Belum ada program</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
