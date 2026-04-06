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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // DataIddahTahfidz, DataLilAthfal, DataPaudqu
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Seed default programs
        DB::table('programs')->insert([
            [
                'name' => 'Iddah Tahfidz',
                'slug' => 'iddah-tahfidz',
                'description' => 'Program Iddah Tahfidz untuk menghafal Al-Quran',
                'price' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Lil Athfal',
                'slug' => 'lil-athfal',
                'description' => 'Program Lil Athfal untuk anak-anak',
                'price' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'PaudQu',
                'slug' => 'paudqu',
                'description' => 'Program PaudQu untuk pendidikan anak usia dini',
                'price' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
