@extends('layouts.santri')

@section('title', 'Daftar Ulang')

@section('content')
<div class="page-header">
    <h1>Daftar Ulang</h1>
    <p>Lengkapi proses daftar ulang untuk program {{ $registration->program->name ?? '-' }}</p>
</div>

@if($decision)
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        Selamat! Anda dinyatakan <strong>LULUS</strong>. Silakan lengkapi dokumen daftar ulang.
    </div>

    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-file-alt"></i> Dokumen Daftar Ulang</h3>
        </div>
        <div class="card-body">
            <div style="background: var(--off-white); padding: 25px; border-radius: 12px; margin-bottom: 25px;">
                <h4 style="margin-bottom: 15px; color: var(--black);">Dokumen yang Perlu Disiapkan:</h4>
                <ul style="list-style: none; padding: 0;">
                    <li style="padding: 10px 0; border-bottom: 1px solid var(--light-gray);">
                        <i class="fas fa-check-circle" style="color: var(--green-islamic); margin-right: 10px;"></i>
                        Fotokopi Kartu Keluarga
                    </li>
                    <li style="padding: 10px 0; border-bottom: 1px solid var(--light-gray);">
                        <i class="fas fa-check-circle" style="color: var(--green-islamic); margin-right: 10px;"></i>
                        Fotokopi Akta Kelahiran
                    </li>
                    <li style="padding: 10px 0; border-bottom: 1px solid var(--light-gray);">
                        <i class="fas fa-check-circle" style="color: var(--green-islamic); margin-right: 10px;"></i>
                        Pas Foto 3x4 (4 lembar)
                    </li>
                    <li style="padding: 10px 0; border-bottom: 1px solid var(--light-gray);">
                        <i class="fas fa-check-circle" style="color: var(--green-islamic); margin-right: 10px;"></i>
                        Fotokopi Ijazah/Rapor terakhir
                    </li>
                    <li style="padding: 10px 0;">
                        <i class="fas fa-check-circle" style="color: var(--green-islamic); margin-right: 10px;"></i>
                        Surat Pernyataan Orang Tua/Wali
                    </li>
                </ul>
            </div>

            <div style="background: linear-gradient(135deg, var(--primary-gold), var(--secondary-gold)); padding: 25px; border-radius: 12px; color: white;">
                <h4 style="margin-bottom: 15px;"><i class="fas fa-info-circle"></i> Informasi Penting</h4>
                <p style="margin-bottom: 10px;">
                    Harap membawa dokumen-dokumen di atas ke sekretariat Maskanul Huffadz pada hari dan jam operasional.
                </p>
                <p style="margin: 0;">
                    Untuk informasi lebih lanjut, silakan hubungi panitia PPDB.
                </p>
            </div>

            <div style="margin-top: 30px; text-align: center;">
                <a href="{{ route('santri.dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
@else
    <div class="card">
        <div class="card-body" style="text-align: center; padding: 60px;">
            <i class="fas fa-lock" style="font-size: 3rem; color: #ccc; margin-bottom: 20px;"></i>
            <h3 style="color: #666;">Halaman Terkunci</h3>
            <p style="color: #999; max-width: 400px; margin: 10px auto;">
                Halaman daftar ulang hanya dapat diakses setelah Anda dinyatakan lulus seleksi PPDB.
            </p>
            <a href="{{ route('santri.pengumuman') }}" class="btn btn-secondary" style="margin-top: 15px;">
                <i class="fas fa-bullhorn"></i> Lihat Pengumuman
            </a>
        </div>
    </div>
@endif
@endsection
