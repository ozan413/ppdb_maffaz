<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InterviewResult extends Model
{
    protected $fillable = [
        'interview_schedule_id',
        'catatan_orang_tua',
        'nilai_tahfidz',
        'nilai_tahsin',
        'nilai_bahasa_arab',
        'nilai_tajwid',
        'catatan_ustad'
    ];

    protected $casts = [
        'nilai_tahfidz' => 'integer',
        'nilai_tahsin' => 'integer',
        'nilai_bahasa_arab' => 'integer',
        'nilai_tajwid' => 'integer'
    ];

    /**
     * Get the interview schedule
     */
    public function interviewSchedule(): BelongsTo
    {
        return $this->belongsTo(InterviewSchedule::class);
    }

    /**
     * Get aspect scores for this result
     */
    public function aspectScores(): HasMany
    {
        return $this->hasMany(InterviewAspectScore::class);
    }

    /**
     * Calculate average academic score (Tahfidz + Tahsin + Bahasa Arab + Tajwid) / 4
     */
    public function getNilaiAkademikAttribute(): float
    {
        $tahfidz = $this->nilai_tahfidz ?? 0;
        $tahsin = $this->nilai_tahsin ?? 0;
        $bahasaArab = $this->nilai_bahasa_arab ?? 0;
        $tajwid = $this->nilai_tajwid ?? 0;

        return round(($tahfidz + $tahsin + $bahasaArab + $tajwid) / 4, 2);
    }

    /**
     * Get total academic score
     */
    public function getTotalAcademicScoreAttribute(): int
    {
        return ($this->nilai_tahfidz ?? 0) + ($this->nilai_tahsin ?? 0) + ($this->nilai_bahasa_arab ?? 0) + ($this->nilai_tajwid ?? 0);
    }

    /**
     * Get wawancara grade based on aspect scores (average converted to letter)
     */
    public function getNilaiWawancaraAttribute(): string
    {
        $scores = $this->aspectScores;
        if ($scores->count() === 0) return '-';

        $total = 0;
        foreach ($scores as $score) {
            $total += $score->score_value;
        }

        $average = $total / $scores->count();

        // Convert average to letter grade
        if ($average >= 3.5) return 'A';
        if ($average >= 2.5) return 'B';
        if ($average >= 1.5) return 'C';
        return 'D';
    }

    /**
     * Get wawancara score percentage (for calculations)
     */
    public function getWawancaraPercentageAttribute(): float
    {
        $scores = $this->aspectScores;
        if ($scores->count() === 0) return 0;

        $total = 0;
        foreach ($scores as $score) {
            $total += $score->score_value;
        }

        // Max score is 4 per aspect, convert to percentage
        return round(($total / ($scores->count() * 4)) * 100, 2);
    }
}
