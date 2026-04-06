@extends('layouts.admin')

@section('title', 'Pengaturan Homepage')

@section('content')
<div class="page-header">
    <h1>Pengaturan Homepage</h1>
    <p>Kelola konten dan pengaturan halaman utama website PPDB</p>
</div>

<form action="{{ route('admin.homepage-settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-cog"></i> Status PPDB</h3>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label>Status Pendaftaran</label>
                <div style="display: flex; align-items: center; gap: 15px;">
                    <label class="toggle-switch">
                        <input type="checkbox" name="is_ppdb_open" value="1" {{ $settings->is_ppdb_open ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                    <span style="font-weight: 500; color: {{ $settings->is_ppdb_open ? '#28a745' : '#dc3545' }};">
                        {{ $settings->is_ppdb_open ? 'PPDB DIBUKA' : 'PPDB DITUTUP' }}
                    </span>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Tanggal Mulai Pendaftaran</label>
                    <input type="date" name="registration_start" class="form-control" value="{{ $settings->registration_start ? $settings->registration_start->format('Y-m-d') : '' }}">
                </div>
                <div class="form-group">
                    <label>Tanggal Akhir Pendaftaran</label>
                    <input type="date" name="registration_end" class="form-control" value="{{ $settings->registration_end ? $settings->registration_end->format('Y-m-d') : '' }}">
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-heading"></i> Informasi Utama</h3>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label>Judul Website <span style="color: red;">*</span></label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $settings->title) }}" required>
            </div>

            <div class="form-group">
                <label>Subtitle</label>
                <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $settings->subtitle) }}" placeholder="Tagline atau slogan">
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description', $settings->description) }}</textarea>
            </div>

            <div class="form-group">
                <label>Tahun Ajaran</label>
                <input type="text" name="academic_year" class="form-control" value="{{ old('academic_year', $settings->academic_year) }}" placeholder="contoh: 2024/2025">
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-phone"></i> Kontak</h3>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label>Alamat</label>
                <textarea name="address" class="form-control" rows="2">{{ old('address', $settings->address) }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Nomor Telepon</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $settings->phone) }}">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $settings->email) }}">
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-image"></i> Media</h3>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label>Logo</label>
                @if($settings->logo)
                    <div style="margin-bottom: 10px;">
                        <img src="{{ asset('storage/' . $settings->logo) }}" alt="Logo" style="max-height: 80px; border-radius: 8px;">
                    </div>
                @endif
                <input type="file" name="logo" class="form-control" accept="image/*">
                <small style="color: #666;">Format: JPG, PNG. Maksimal 2MB</small>
            </div>

            <div class="form-group" style="margin-top: 20px;">
                <label>Gambar Hero (Bagian Utama)</label>
                @if($settings->hero_image)
                    <div style="margin-bottom: 10px;">
                        <img src="{{ asset('storage/' . $settings->hero_image) }}" alt="Hero" style="max-height: 120px; border-radius: 8px;">
                    </div>
                @endif
                <input type="file" name="hero_image" class="form-control" accept="image/*">
                <small style="color: #666;">Gambar utama di halaman depan. Format: JPG, PNG. Maksimal 5MB</small>
            </div>

            <div class="form-group" style="margin-top: 20px;">
                <label>Gambar About (Tentang Kami)</label>
                @if($settings->about_image)
                    <div style="margin-bottom: 10px;">
                        <img src="{{ asset('storage/' . $settings->about_image) }}" alt="About" style="max-height: 120px; border-radius: 8px;">
                    </div>
                @endif
                <input type="file" name="about_image" class="form-control" accept="image/*">
                <small style="color: #666;">Gambar di bagian "Tentang Kami". Format: JPG, PNG. Maksimal 5MB</small>
            </div>
        </div>
    </div>

    <div style="display: flex; gap: 15px; margin-top: 20px;">
        <button type="submit" class="btn btn-primary" style="flex: 1;">
            <i class="fas fa-save"></i> Simpan Pengaturan
        </button>
    </div>
</form>
@endsection
