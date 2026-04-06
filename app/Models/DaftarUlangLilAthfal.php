<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaftarUlangLilAthfal extends Model
{
    protected $table = 'daftar_ulang_lil_athfal';

    protected $fillable = [
        'registration_id',
        'nik',
        'nisn',
        'kondisi_ortu',
        'jumlah_saudara',
        'pendidikan_ayah',
        'pendidikan_ibu',
        'pendidikan_wali',
        'status_rumah',
        'kondisi_rumah',
        'perlengkapan_rumah',
        'prestasi',
        'pas_foto',
        'riwayat_pendidikan_formal',
        'jumlah_hafalan',
    ];

    protected $casts = [
        'perlengkapan_rumah' => 'array',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}
