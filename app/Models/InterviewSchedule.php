<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InterviewSchedule extends Model
{
    protected $fillable = [
        'registration_id',
        'ustad_id',
        'panitia_id',
        'schedule_date',
        'schedule_time',
        'media',
        'notes',
        'status'
    ];

    protected $casts = [
        'schedule_date' => 'date',
        'schedule_time' => 'datetime:H:i'
    ];

    /**
     * Get the registration
     */
    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    /**
     * Get the ustad assigned to this interview
     */
    public function ustad(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ustad_id');
    }

    /**
     * Get the panitia who scheduled this interview
     */
    public function panitia(): BelongsTo
    {
        return $this->belongsTo(User::class, 'panitia_id');
    }

    /**
     * Get the interview result
     */
    public function result(): HasOne
    {
        return $this->hasOne(InterviewResult::class);
    }

    /**
     * Check if interview is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Scope for scheduled interviews
     */
    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }
}
