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
        Schema::create('interview_aspect_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('interview_result_id')->constrained('interview_results')->onDelete('cascade');
            $table->foreignId('aspect_id')->constrained('assessment_aspects')->onDelete('cascade');
            $table->enum('score', ['A', 'B', 'C', 'D']);
            $table->timestamps();
            
            // Unique constraint to prevent duplicate scores for same aspect
            $table->unique(['interview_result_id', 'aspect_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interview_aspect_scores');
    }
};
