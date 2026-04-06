<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataIddahTahfidz extends Model
{
    protected $table = 'data_iddah_tahfidz';

    protected $fillable = [
        'registration_id',
        'program_id',
        'jalur_program',
        'jalur_masuk_program',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'usia',
        'gender',
        'pendidikan_terakhir',
        'riwayat_pendidikan_nonformal',
        'no_hp',
        'email',
        'provinsi_domisili',
        'kota_kabupaten',
        'domisili_lengkap',
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
        'pekerjaan_wali',
        'penghasilan_wali',
        'no_telepon_wali'
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
