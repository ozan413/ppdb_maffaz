<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_lil_athfal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained('registrations')->onDelete('cascade');
            $table->foreignId('program_id')->constrained('programs')->onDelete('cascade');
            
            // Program pilihan
            $table->enum('program_pilihan', ['Lil Athfal Reguler', 'Lil Athfal Beasiswa']);
            
            // Data Pribadi
            $table->string('nama_lengkap');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->integer('usia');
            $table->enum('gender', ['Laki-Laki', 'Perempuan']);
            $table->string('pendidikan_terakhir');
            $table->string('riwayat_pendidikan_formal');
            $table->string('riwayat_pendidikan_nonformal');
            $table->string('riwayat_sakit')->nullable();
            
            // Kontak
            $table->string('no_hp');
            $table->string('email');
            
            // Alamat
            $table->string('provinsi_domisili');
            $table->string('kota_kabupaten');
            $table->text('domisili_lengkap');
            
            // Dokumen
            $table->string('pas_foto')->nullable();
            
            // Informasi Tambahan
            $table->string('sumber_informasi')->nullable();
            
            // Data Orang Tua
            $table->string('nama_ayah');
            $table->string('pekerjaan_ayah');
            $table->string('penghasilan_ayah');
            $table->string('nama_ibu');
            $table->string('pekerjaan_ibu');
            $table->string('penghasilan_ibu');
            
            // Hafalan
            $table->enum('pengalaman_menghafal', ['pernah', 'belum'])->default('belum');
            $table->string('jumlah_hafalan');
            $table->enum('pemahaman_tajwid', ['sudah_menguasai', 'pernah_belajar_tapi_belum_menguasai', 'belum_pernah_belajar']);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_lil_athfal');
    }
};
