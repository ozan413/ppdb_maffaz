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
        Schema::table('interview_results', function (Blueprint $table) {
            $table->integer('nilai_tajwid')->nullable()->after('nilai_bahasa_arab');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('interview_results', function (Blueprint $table) {
            $table->dropColumn('nilai_tajwid');
        });
    }
};
