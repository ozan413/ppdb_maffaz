<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageSetting extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'academic_year',
        'address',
        'phone',
        'email',
        'logo',
        'hero_image',
        'about_image',
        'is_ppdb_open',
        'registration_start',
        'registration_end'
    ];

    protected $casts = [
        'is_ppdb_open' => 'boolean',
        'registration_start' => 'date',
        'registration_end' => 'date'
    ];

    /**
     * Get the first (and only) settings record
     */
    public static function getSettings()
    {
        return self::first() ?? new self();
    }

    /**
     * Check if PPDB registration is open
     */
    public static function isPPDBOpen(): bool
    {
        $settings = self::getSettings();
        return $settings->is_ppdb_open ?? false;
    }
}
