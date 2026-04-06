<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterviewAspectScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'interview_result_id',
        'aspect_id',
        'score',
    ];

    /**
     * Get the interview result
     */
    public function interviewResult()
    {
        return $this->belongsTo(InterviewResult::class);
    }

    /**
     * Get the aspect
     */
    public function aspect()
    {
        return $this->belongsTo(AssessmentAspect::class, 'aspect_id');
    }

    /**
     * Get score label (same as score for letter grades)
     */
    public function getScoreLabelAttribute()
    {
        return $this->score;
    }

    /**
     * Get score value for calculation (A=4, B=3, C=2, D=1)
     */
    public function getScoreValueAttribute()
    {
        return match($this->score) {
            'A' => 4,
            'B' => 3,
            'C' => 2,
            'D' => 1,
            default => 0,
        };
    }

    /**
     * Get score description
     */
    public function getScoreDescriptionAttribute()
    {
        return match($this->score) {
            'A' => 'Sangat Baik',
            'B' => 'Baik',
            'C' => 'Cukup',
            'D' => 'Kurang',
            default => '-',
        };
    }
}
