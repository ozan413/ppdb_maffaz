<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daftar_ulang_lil_athfal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->unique()->constrained('registrations')->onDelete('cascade');
            
            // Jalur Program
            $table->enum('jalur_program', [
                'Beasiswa Dhuafa',
                'Beasiswa Dhuafa Yatim',
                'Beasiswa Dhuafa Piatu',
                'Beasiswa Dhuafa Muallaf',
                'Beasiswa Dhuafa Prestasi',
                'Reguler/Berbayar'
            ]);
            
            // Identitas
            $table->string('nik', 16);
            $table->string('nisn', 10);
            
            // Kondisi Keluarga
            $table->enum('kondisi_ortu', ['Lengkap', 'Yatim', 'Piatu', 'Yatim/Piatu', 'Cerai']);
            $table->integer('jumlah_saudara');
            $table->string('ukuran_jubah', 10);
            
            // Data Ayah
            $table->enum('pendidikan_ayah', ['SD', 'SMP', 'SMA/SMK', 'D1', 'D2', 'D3', 'S1', 'S2', 'S3'])->nullable();
            $table->string('no_telepon_ayah', 15)->nullable();
            
            // Data Ibu
            $table->enum('pendidikan_ibu', ['SD', 'SMP', 'SMA/SMK', 'D1', 'D2', 'D3', 'S1', 'S2', 'S3'])->nullable();
            $table->string('no_telepon_ibu', 15)->nullable();
            
            // Data Wali
            $table->string('nama_wali')->nullable();
            $table->string('no_telepon_wali', 15)->nullable();
            $table->enum('pendidikan_wali', ['SD', 'SMP', 'SMA/SMK', 'D1', 'D2', 'D3', 'S1', 'S2', 'S3'])->nullable();
            $table->string('pekerjaan_wali')->nullable();
            $table->enum('penghasilan_wali', [
                '0 - Rp. 500.000',
                'Rp. 500.000 - Rp. 1.500.000',
                'Rp. 1.500.000 - Rp. 3.000.000',
                'Rp. 3.000.000 - Rp. 5.000.000',
                'Diatas Rp. 5.000.000'
            ])->nullable();
            
            // Alamat & Rumah
            $table->text('alamat_ortu_wali');
            $table->enum('status_rumah', ['Milik Orang Tua', 'Milik Pribadi', 'Rumah Dinas', 'Kontrakan/Sewa']);
            $table->enum('kondisi_rumah', ['Gubuk', 'Permanen', 'Semi Permanen']);
            $table->json('perlengkapan_rumah')->nullable();
            
            // Prestasi
            $table->text('prestasi')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daftar_ulang_lil_athfal');
    }
};
