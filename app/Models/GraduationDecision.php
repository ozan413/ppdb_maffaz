<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GraduationDecision extends Model
{
    protected $fillable = [
        'registration_id',
        'panitia_id',
        'is_lulus',
        'notes',
        'decided_at'
    ];

    protected $casts = [
        'is_lulus' => 'boolean',
        'decided_at' => 'datetime'
    ];

    /**
     * Get the registration
     */
    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    /**
     * Get the panitia who made this decision
     */
    public function panitia(): BelongsTo
    {
        return $this->belongsTo(User::class, 'panitia_id');
    }
}
