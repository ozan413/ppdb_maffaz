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
        Schema::table('daftar_ulang_iddah_tahfidz', function (Blueprint $table) {
            $table->string('jumlah_hafalan_juz')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daftar_ulang_iddah_tahfidz', function (Blueprint $table) {
            $table->integer('jumlah_hafalan_juz')->nullable()->change();
        });
    }
};
