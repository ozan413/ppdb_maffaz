<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daftar_ulang_iddah_tahfidz', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->unique()->constrained('registrations')->onDelete('cascade');
            
            // Identitas
            $table->string('nik', 16);
            $table->string('nisn', 10);
            $table->integer('jumlah_saudara');
            $table->string('kelas_jenjang_pendidikan');
            $table->string('ukuran_jubah', 10);
            
            // Data Ayah
            $table->string('pekerjaan_ayah')->nullable();
            $table->enum('penghasilan_ayah', [
                '0 - Rp. 500.000',
                'Rp. 500.000 - Rp. 1.500.000',
                'Rp. 1.500.000 - Rp. 3.000.000',
                'Rp. 3.000.000 - Rp. 5.000.000',
                'Diatas Rp. 5.000.000'
            ])->nullable();
            $table->enum('pendidikan_ayah', ['SD', 'SMP', 'SMA/SMK', 'D1', 'D2', 'D3', 'S1', 'S2', 'S3'])->nullable();
            $table->string('no_telepon_ayah', 15)->nullable();
            
            // Data Ibu
            $table->string('pekerjaan_ibu')->nullable();
            $table->enum('penghasilan_ibu', [
                '0 - Rp. 500.000',
                'Rp. 500.000 - Rp. 1.500.000',
                'Rp. 1.500.000 - Rp. 3.000.000',
                'Rp. 3.000.000 - Rp. 5.000.000',
                'Diatas Rp. 5.000.000'
            ])->nullable();
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
            
            // Pengalaman Hafalan
            $table->enum('pengalaman_menghafal', ['Pernah', 'Belum']);
            $table->integer('jumlah_hafalan_juz')->nullable();
            $table->enum('pemahaman_tajwid', [
                'Sudah Menguasai',
                'Pernah Belajar tetapi Belum Menguasai',
                'Belum Pernah Belajar'
            ]);
            
            // Pernyataan
            $table->boolean('pernyataan_data_benar')->default(false);
            $table->boolean('pernyataan_ikut_aturan')->default(false);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daftar_ulang_iddah_tahfidz');
    }
};
