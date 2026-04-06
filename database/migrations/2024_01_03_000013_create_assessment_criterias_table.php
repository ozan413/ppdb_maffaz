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
        Schema::create('assessment_criterias', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // nama kriteria, e.g. "Adab & Akhlak"
            $table->string('academic_year'); // tahun ajaran, e.g. "2024/2025"
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_criterias');
    }
};
