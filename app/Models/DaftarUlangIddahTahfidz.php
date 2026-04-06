<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaftarUlangIddahTahfidz extends Model
{
    protected $table = 'daftar_ulang_iddah_tahfidz';

    protected $fillable = [
        'registration_id',
        'nik',
        'nisn',
        'jumlah_saudara',
        'kelas_jenjang_pendidikan',
        'pendidikan_ayah',
        'pendidikan_ibu',
        'pendidikan_wali',
        'status_rumah',
        'kondisi_rumah',
        'perlengkapan_rumah',
        'prestasi',
        'pas_foto',
        'riwayat_pendidikan_formal',
        'pengalaman_menghafal',
        'jumlah_hafalan_juz',
        'pemahaman_tajwid',
        'pernyataan_data_benar',
        'pernyataan_ikut_aturan',
    ];

    protected $casts = [
        'perlengkapan_rumah' => 'array',
        'pernyataan_data_benar' => 'boolean',
        'pernyataan_ikut_aturan' => 'boolean',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}
