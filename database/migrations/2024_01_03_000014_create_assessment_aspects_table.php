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
        Schema::create('assessment_aspects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('criteria_id')->constrained('assessment_criterias')->onDelete('cascade');
            $table->string('name'); // nama aspek, e.g. "Sopan santun"
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_aspects');
    }
};
