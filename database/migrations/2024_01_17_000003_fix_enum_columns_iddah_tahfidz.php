<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Change ENUM columns to VARCHAR for flexibility
        Schema::table('daftar_ulang_iddah_tahfidz', function (Blueprint $table) {
            // Change pendidikan columns from enum to string
            $table->string('pendidikan_ayah')->nullable()->change();
            $table->string('pendidikan_ibu')->nullable()->change();
            $table->string('pendidikan_wali')->nullable()->change();
            
            // Change status_rumah from enum to string
            $table->string('status_rumah')->nullable()->change();
            $table->string('kondisi_rumah')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse, string is more flexible
    }
};
