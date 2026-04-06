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
        Schema::create('homepage_settings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('PPDB Maskanul Huffadz');
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('academic_year')->nullable(); // Tahun Ajaran
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('logo')->nullable();
            $table->string('hero_image')->nullable();
            $table->boolean('is_ppdb_open')->default(false);
            $table->date('registration_start')->nullable();
            $table->date('registration_end')->nullable();
            $table->timestamps();
        });

        // Seed default settings
        DB::table('homepage_settings')->insert([
            'title' => 'PPDB Maskanul Huffadz',
            'subtitle' => 'Penerimaan Peserta Didik Baru',
            'description' => 'Selamat datang di portal pendaftaran Maskanul Huffadz. Kami menyediakan program pendidikan Al-Quran berkualitas untuk putra-putri Anda.',
            'academic_year' => '2025/2026',
            'address' => 'Jl. Pesantren No. 1, Kota',
            'phone' => '08xxxxxxxxxx',
            'email' => 'info@maskanulhuffadz.ac.id',
            'is_ppdb_open' => false,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homepage_settings');
    }
};
