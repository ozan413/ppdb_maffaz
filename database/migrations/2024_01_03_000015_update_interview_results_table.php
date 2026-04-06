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
        // Drop old columns and add new structure
        Schema::table('interview_results', function (Blueprint $table) {
            // Drop old columns if exist
            if (Schema::hasColumn('interview_results', 'nilai_bacaan')) {
                $table->dropColumn('nilai_bacaan');
            }
            if (Schema::hasColumn('interview_results', 'nilai_hafalan')) {
                $table->dropColumn('nilai_hafalan');
            }
            if (Schema::hasColumn('interview_results', 'nilai_adab')) {
                $table->dropColumn('nilai_adab');
            }
            if (Schema::hasColumn('interview_results', 'catatan')) {
                $table->dropColumn('catatan');
            }
        });

        Schema::table('interview_results', function (Blueprint $table) {
            // Add new columns
            $table->text('catatan_orang_tua')->nullable()->after('interview_schedule_id');
            $table->integer('nilai_tahfidz')->nullable()->after('catatan_orang_tua');
            $table->integer('nilai_tahsin')->nullable()->after('nilai_tahfidz');
            $table->integer('nilai_bahasa_arab')->nullable()->after('nilai_tahsin');
            $table->text('catatan_ustad')->nullable()->after('nilai_bahasa_arab');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('interview_results', function (Blueprint $table) {
            $table->dropColumn(['catatan_orang_tua', 'nilai_tahfidz', 'nilai_tahsin', 'nilai_bahasa_arab', 'catatan_ustad']);
            
            // Restore old columns
            $table->integer('nilai_bacaan')->default(0);
            $table->integer('nilai_hafalan')->default(0);
            $table->integer('nilai_adab')->default(0);
            $table->text('catatan')->nullable();
        });
    }
};
