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
        // First, convert existing data or clear it
        DB::table('interview_aspect_scores')->delete();
        
        // Then change score enum from words to letter grades
        DB::statement("ALTER TABLE interview_aspect_scores MODIFY COLUMN score ENUM('A', 'B', 'C', 'D')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE interview_aspect_scores MODIFY COLUMN score ENUM('sangat_baik', 'baik', 'cukup', 'kurang')");
    }
};
