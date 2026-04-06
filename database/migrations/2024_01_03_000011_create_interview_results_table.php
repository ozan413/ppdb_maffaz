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
        Schema::create('interview_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('interview_schedule_id')->constrained('interview_schedules')->onDelete('cascade');
            $table->integer('nilai_bacaan')->nullable(); // Nilai 1-100
            $table->integer('nilai_hafalan')->nullable();
            $table->integer('nilai_adab')->nullable();
            $table->integer('nilai_total')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interview_results');
    }
};
