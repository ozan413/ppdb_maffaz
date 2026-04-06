@extends('layouts.admin')

@section('title', 'Tambah Program')

@section('content')
<div class="page-header">
    <h1>Tambah Program Baru</h1>
    <p>Buat program pendidikan baru</p>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.programs.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Nama Program <span style="color: red;">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label>Slug <span style="color: red;">*</span></label>
                <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" placeholder="contoh: lil-athfal" required>
                <small style="color: #666;">Digunakan untuk URL. Hanya huruf kecil, angka, dan strip.</small>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label>Harga Pendaftaran <span style="color: red;">*</span></label>
                <input type="number" name="price" class="form-control" value="{{ old('price', 0) }}" min="0" required>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="is_active" class="form-control">
                    <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div style="display: flex; gap: 15px; margin-top: 20px;">
                <a href="{{ route('admin.programs.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary" style="flex: 1;">
                    <i class="fas fa-save"></i> Simpan Program
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
