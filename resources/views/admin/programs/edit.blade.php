@extends('layouts.admin')

@section('title', 'Edit Program')

@section('content')
<div class="page-header">
    <h1>Edit Program</h1>
    <p>Ubah data program {{ $program->name }}</p>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.programs.update', $program) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nama Program <span style="color: red;">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $program->name) }}" required>
            </div>

            <div class="form-group">
                <label>Slug <span style="color: red;">*</span></label>
                <input type="text" name="slug" class="form-control" value="{{ old('slug', $program->slug) }}" required>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $program->description) }}</textarea>
            </div>

            <div class="form-group">
                <label>Harga Pendaftaran <span style="color: red;">*</span></label>
                <input type="number" name="price" class="form-control" value="{{ old('price', $program->price) }}" min="0" required>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="is_active" class="form-control">
                    <option value="1" {{ old('is_active', $program->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('is_active', $program->is_active) == 0 ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div style="display: flex; gap: 15px; margin-top: 20px;">
                <a href="{{ route('admin.programs.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary" style="flex: 1;">
                    <i class="fas fa-save"></i> Update Program
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
