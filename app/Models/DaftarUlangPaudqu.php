<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaftarUlangPaudqu extends Model
{
    protected $table = 'daftar_ulang_paudqu';

    protected $fillable = [
        'registration_id',
        'anak_ke',
        'jumlah_saudara',
        'nik',
        'pendidikan_ayah',
        'pekerjaan_ayah',
        'penghasilan_ayah',
        'pendidikan_ibu',
        'pekerjaan_ibu',
        'penghasilan_ibu',
        'nama_wali',
        'pendidikan_wali',
        'pekerjaan_wali',
        'penghasilan_wali',
        'no_telepon_wali',
        'alamat_ortu_wali',
        'pas_foto',
        'pernyataan_data_benar',
        'pernyataan_ikut_aturan',
    ];

    protected $casts = [
        'pernyataan_data_benar' => 'boolean',
        'pernyataan_ikut_aturan' => 'boolean',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}
