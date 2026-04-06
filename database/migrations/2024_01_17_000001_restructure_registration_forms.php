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
        // ============================================
        // 1. UPDATE data_paudqu TABLE
        // ============================================
        Schema::table('data_paudqu', function (Blueprint $table) {
            // ADD new fields
            $table->string('jalur_masuk_program')->nullable()->after('durasi_program');
            $table->string('email')->nullable()->after('gender');
            $table->string('no_telepon_ayah', 20)->nullable()->after('nama_ayah');
            $table->string('no_telepon_ibu', 20)->nullable()->after('nama_ibu');
        });

        // Remove old fields if they exist (safe removal)
        if (Schema::hasColumn('data_paudqu', 'nama_panggilan')) {
            Schema::table('data_paudqu', function (Blueprint $table) {
                $table->dropColumn('nama_panggilan');
            });
        }
        if (Schema::hasColumn('data_paudqu', 'riwayat_kesehatan')) {
            Schema::table('data_paudqu', function (Blueprint $table) {
                $table->dropColumn('riwayat_kesehatan');
            });
        }
        if (Schema::hasColumn('data_paudqu', 'riwayat_alergi')) {
            Schema::table('data_paudqu', function (Blueprint $table) {
                $table->dropColumn('riwayat_alergi');
            });
        }
        if (Schema::hasColumn('data_paudqu', 'pas_foto')) {
            Schema::table('data_paudqu', function (Blueprint $table) {
                $table->dropColumn('pas_foto');
            });
        }

        // ============================================
        // 2. UPDATE daftar_ulang_paudqu TABLE
        // ============================================
        Schema::table('daftar_ulang_paudqu', function (Blueprint $table) {
            // ADD pas_foto field
            $table->string('pas_foto')->nullable()->after('alamat_ortu_wali');
        });

        // ============================================
        // 3. UPDATE data_lil_athfal TABLE
        // ============================================
        Schema::table('data_lil_athfal', function (Blueprint $table) {
            // ADD new fields
            $table->string('jalur_masuk_program')->nullable()->after('program_pilihan');
            $table->string('no_telepon_ayah', 20)->nullable()->after('penghasilan_ayah');
            $table->string('no_telepon_ibu', 20)->nullable()->after('penghasilan_ibu');
            $table->string('nama_wali')->nullable()->after('no_telepon_ibu');
            $table->string('no_telepon_wali', 20)->nullable()->after('nama_wali');
            $table->string('pekerjaan_wali')->nullable()->after('no_telepon_wali');
            $table->string('penghasilan_wali')->nullable()->after('pekerjaan_wali');
            $table->text('alamat_ortu_wali')->nullable()->after('penghasilan_wali');
        });

        // Remove old fields if they exist
        if (Schema::hasColumn('data_lil_athfal', 'no_hp')) {
            Schema::table('data_lil_athfal', function (Blueprint $table) {
                $table->dropColumn('no_hp');
            });
        }
        if (Schema::hasColumn('data_lil_athfal', 'email')) {
            Schema::table('data_lil_athfal', function (Blueprint $table) {
                $table->dropColumn('email');
            });
        }
        if (Schema::hasColumn('data_lil_athfal', 'riwayat_sakit')) {
            Schema::table('data_lil_athfal', function (Blueprint $table) {
                $table->dropColumn('riwayat_sakit');
            });
        }
        if (Schema::hasColumn('data_lil_athfal', 'riwayat_pendidikan_formal')) {
            Schema::table('data_lil_athfal', function (Blueprint $table) {
                $table->dropColumn('riwayat_pendidikan_formal');
            });
        }
        if (Schema::hasColumn('data_lil_athfal', 'pengalaman_menghafal')) {
            Schema::table('data_lil_athfal', function (Blueprint $table) {
                $table->dropColumn('pengalaman_menghafal');
            });
        }
        if (Schema::hasColumn('data_lil_athfal', 'jumlah_hafalan')) {
            Schema::table('data_lil_athfal', function (Blueprint $table) {
                $table->dropColumn('jumlah_hafalan');
            });
        }
        if (Schema::hasColumn('data_lil_athfal', 'pas_foto')) {
            Schema::table('data_lil_athfal', function (Blueprint $table) {
                $table->dropColumn('pas_foto');
            });
        }

        // ============================================
        // 4. UPDATE daftar_ulang_lil_athfal TABLE
        // ============================================
        Schema::table('daftar_ulang_lil_athfal', function (Blueprint $table) {
            // ADD new fields
            $table->string('pas_foto')->nullable()->after('prestasi');
            $table->text('riwayat_pendidikan_formal')->nullable()->after('pas_foto');
            $table->string('jumlah_hafalan')->nullable()->after('riwayat_pendidikan_formal');
        });

        // Remove old fields if they exist
        if (Schema::hasColumn('daftar_ulang_lil_athfal', 'jalur_program')) {
            Schema::table('daftar_ulang_lil_athfal', function (Blueprint $table) {
                $table->dropColumn('jalur_program');
            });
        }
        if (Schema::hasColumn('daftar_ulang_lil_athfal', 'ukuran_jubah')) {
            Schema::table('daftar_ulang_lil_athfal', function (Blueprint $table) {
                $table->dropColumn('ukuran_jubah');
            });
        }
        if (Schema::hasColumn('daftar_ulang_lil_athfal', 'no_telepon_ayah')) {
            Schema::table('daftar_ulang_lil_athfal', function (Blueprint $table) {
                $table->dropColumn('no_telepon_ayah');
            });
        }
        if (Schema::hasColumn('daftar_ulang_lil_athfal', 'no_telepon_ibu')) {
            Schema::table('daftar_ulang_lil_athfal', function (Blueprint $table) {
                $table->dropColumn('no_telepon_ibu');
            });
        }
        if (Schema::hasColumn('daftar_ulang_lil_athfal', 'nama_wali')) {
            Schema::table('daftar_ulang_lil_athfal', function (Blueprint $table) {
                $table->dropColumn('nama_wali');
            });
        }
        if (Schema::hasColumn('daftar_ulang_lil_athfal', 'no_telepon_wali')) {
            Schema::table('daftar_ulang_lil_athfal', function (Blueprint $table) {
                $table->dropColumn('no_telepon_wali');
            });
        }
        if (Schema::hasColumn('daftar_ulang_lil_athfal', 'pekerjaan_wali')) {
            Schema::table('daftar_ulang_lil_athfal', function (Blueprint $table) {
                $table->dropColumn('pekerjaan_wali');
            });
        }
        if (Schema::hasColumn('daftar_ulang_lil_athfal', 'penghasilan_wali')) {
            Schema::table('daftar_ulang_lil_athfal', function (Blueprint $table) {
                $table->dropColumn('penghasilan_wali');
            });
        }
        if (Schema::hasColumn('daftar_ulang_lil_athfal', 'alamat_ortu_wali')) {
            Schema::table('daftar_ulang_lil_athfal', function (Blueprint $table) {
                $table->dropColumn('alamat_ortu_wali');
            });
        }

        // ============================================
        // 5. UPDATE data_iddah_tahfidz TABLE
        // ============================================
        Schema::table('data_iddah_tahfidz', function (Blueprint $table) {
            // ADD new fields
            $table->string('jalur_program')->nullable()->after('program_id');
            $table->string('jalur_masuk_program')->nullable()->after('jalur_program');
            $table->string('pekerjaan_ayah')->nullable()->after('nama_ayah');
            $table->string('penghasilan_ayah')->nullable()->after('pekerjaan_ayah');
            $table->string('no_telepon_ayah', 20)->nullable()->after('penghasilan_ayah');
            $table->string('pekerjaan_ibu')->nullable()->after('nama_ibu');
            $table->string('penghasilan_ibu')->nullable()->after('pekerjaan_ibu');
            $table->string('no_telepon_ibu', 20)->nullable()->after('penghasilan_ibu');
            $table->string('nama_wali')->nullable()->after('no_telepon_ibu');
            $table->string('pekerjaan_wali')->nullable()->after('nama_wali');
            $table->string('penghasilan_wali')->nullable()->after('pekerjaan_wali');
            $table->string('no_telepon_wali', 20)->nullable()->after('penghasilan_wali');
        });

        // Remove old fields if they exist
        if (Schema::hasColumn('data_iddah_tahfidz', 'riwayat_pendidikan_formal')) {
            Schema::table('data_iddah_tahfidz', function (Blueprint $table) {
                $table->dropColumn('riwayat_pendidikan_formal');
            });
        }
        if (Schema::hasColumn('data_iddah_tahfidz', 'pas_foto')) {
            Schema::table('data_iddah_tahfidz', function (Blueprint $table) {
                $table->dropColumn('pas_foto');
            });
        }

        // ============================================
        // 6. UPDATE daftar_ulang_iddah_tahfidz TABLE
        // ============================================
        Schema::table('daftar_ulang_iddah_tahfidz', function (Blueprint $table) {
            // ADD new fields
            $table->string('pas_foto')->nullable()->after('prestasi');
            $table->text('riwayat_pendidikan_formal')->nullable()->after('pas_foto');
        });

        // Remove old fields if they exist
        if (Schema::hasColumn('daftar_ulang_iddah_tahfidz', 'ukuran_jubah')) {
            Schema::table('daftar_ulang_iddah_tahfidz', function (Blueprint $table) {
                $table->dropColumn('ukuran_jubah');
            });
        }
        if (Schema::hasColumn('daftar_ulang_iddah_tahfidz', 'pekerjaan_ayah')) {
            Schema::table('daftar_ulang_iddah_tahfidz', function (Blueprint $table) {
                $table->dropColumn('pekerjaan_ayah');
            });
        }
        if (Schema::hasColumn('daftar_ulang_iddah_tahfidz', 'penghasilan_ayah')) {
            Schema::table('daftar_ulang_iddah_tahfidz', function (Blueprint $table) {
                $table->dropColumn('penghasilan_ayah');
            });
        }
        if (Schema::hasColumn('daftar_ulang_iddah_tahfidz', 'no_telepon_ayah')) {
            Schema::table('daftar_ulang_iddah_tahfidz', function (Blueprint $table) {
                $table->dropColumn('no_telepon_ayah');
            });
        }
        if (Schema::hasColumn('daftar_ulang_iddah_tahfidz', 'pekerjaan_ibu')) {
            Schema::table('daftar_ulang_iddah_tahfidz', function (Blueprint $table) {
                $table->dropColumn('pekerjaan_ibu');
            });
        }
        if (Schema::hasColumn('daftar_ulang_iddah_tahfidz', 'penghasilan_ibu')) {
            Schema::table('daftar_ulang_iddah_tahfidz', function (Blueprint $table) {
                $table->dropColumn('penghasilan_ibu');
            });
        }
        if (Schema::hasColumn('daftar_ulang_iddah_tahfidz', 'no_telepon_ibu')) {
            Schema::table('daftar_ulang_iddah_tahfidz', function (Blueprint $table) {
                $table->dropColumn('no_telepon_ibu');
            });
        }
        if (Schema::hasColumn('daftar_ulang_iddah_tahfidz', 'nama_wali')) {
            Schema::table('daftar_ulang_iddah_tahfidz', function (Blueprint $table) {
                $table->dropColumn('nama_wali');
            });
        }
        if (Schema::hasColumn('daftar_ulang_iddah_tahfidz', 'pekerjaan_wali')) {
            Schema::table('daftar_ulang_iddah_tahfidz', function (Blueprint $table) {
                $table->dropColumn('pekerjaan_wali');
            });
        }
        if (Schema::hasColumn('daftar_ulang_iddah_tahfidz', 'penghasilan_wali')) {
            Schema::table('daftar_ulang_iddah_tahfidz', function (Blueprint $table) {
                $table->dropColumn('penghasilan_wali');
            });
        }
        if (Schema::hasColumn('daftar_ulang_iddah_tahfidz', 'no_telepon_wali')) {
            Schema::table('daftar_ulang_iddah_tahfidz', function (Blueprint $table) {
                $table->dropColumn('no_telepon_wali');
            });
        }
        if (Schema::hasColumn('daftar_ulang_iddah_tahfidz', 'alamat_ortu_wali')) {
            Schema::table('daftar_ulang_iddah_tahfidz', function (Blueprint $table) {
                $table->dropColumn('alamat_ortu_wali');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse changes would be complex, just note the fields to restore/remove
        // For simplicity, this migration is not easily reversible
    }
};
