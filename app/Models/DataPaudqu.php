<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataPaudqu extends Model
{
    protected $table = 'data_paudqu';

    protected $fillable = [
        'registration_id',
        'program_id',
        'program_pilihan',
        'durasi_program',
        'jalur_masuk_program',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'usia',
        'gender',
        'email',
        'provinsi_domisili',
        'kota_kabupaten',
        'domisili_lengkap',
        'sumber_informasi',
        'nama_ayah',
        'no_telepon_ayah',
        'nama_ibu',
        'no_telepon_ibu'
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
