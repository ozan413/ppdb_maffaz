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
        Schema::create('data_iddah_tahfidz', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained('registrations')->onDelete('cascade');
            $table->foreignId('program_id')->constrained('programs')->onDelete('cascade');
            
            // Data Pribadi
            $table->string('nama_lengkap');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->integer('usia');
            $table->enum('gender', ['Laki-Laki', 'Perempuan']);
            $table->string('pendidikan_terakhir');
            $table->string('riwayat_pendidikan_formal');
            $table->string('riwayat_pendidikan_nonformal');
            
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
            $table->string('nama_ibu');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_iddah_tahfidz');
    }
};
