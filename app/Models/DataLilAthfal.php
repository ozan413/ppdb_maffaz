<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataLilAthfal extends Model
{
    protected $table = 'data_lil_athfal';

    protected $fillable = [
        'registration_id',
        'program_id',
        'program_pilihan',
        'jalur_masuk_program',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'usia',
        'gender',
        'pendidikan_terakhir',
        'riwayat_pendidikan_nonformal',
        'provinsi_domisili',
        'kota_kabupaten',
        'domisili_lengkap',
        'pemahaman_tajwid',
        'sumber_informasi',
        'nama_ayah',
        'pekerjaan_ayah',
        'penghasilan_ayah',
        'no_telepon_ayah',
        'nama_ibu',
        'pekerjaan_ibu',
        'penghasilan_ibu',
        'no_telepon_ibu',
        'nama_wali',
        'no_telepon_wali',
        'pekerjaan_wali',
        'penghasilan_wali',
        'alamat_ortu_wali'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'usia' => 'integer'
    ];

    /**
     * Get the registration
     */
    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    /**
     * Get the program
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }
}
