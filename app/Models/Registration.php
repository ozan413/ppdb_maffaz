<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Registration extends Model
{
    protected $fillable = [
        'user_id',
        'program_id',
        'status',
        'payment_status',
        'is_program_locked'
    ];

    protected $casts = [
        'is_program_locked' => 'boolean'
    ];

    /**
     * Get the user that owns this registration
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the program for this registration
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Get the payment for this registration
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Get the interview schedule for this registration
     */
    public function interviewSchedule(): HasOne
    {
        return $this->hasOne(InterviewSchedule::class);
    }

    /**
     * Get the graduation decision for this registration
     */
    public function graduationDecision(): HasOne
    {
        return $this->hasOne(GraduationDecision::class);
    }

    /**
     * Get program-specific data based on program slug
     */
    public function getProgramData()
    {
        $programSlug = $this->program->slug ?? null;
        
        switch ($programSlug) {
            case 'lil-athfal':
                return DataLilAthfal::where('registration_id', $this->id)->first();
            case 'iddah-tahfidz':
                return DataIddahTahfidz::where('registration_id', $this->id)->first();
            case 'paudqu':
                return DataPaudqu::where('registration_id', $this->id)->first();
            default:
                return null;
        }
    }

    /**
     * Scope for paid registrations
     */
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    /**
     * Scope for submitted registrations
     */
    public function scopeSubmitted($query)
    {
        return $query->where('status', 'submitted');
    }
}
