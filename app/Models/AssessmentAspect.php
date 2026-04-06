<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentAspect extends Model
{
    use HasFactory;

    protected $fillable = [
        'criteria_id',
        'name',
        'order',
    ];

    /**
     * Get the criteria this aspect belongs to
     */
    public function criteria()
    {
        return $this->belongsTo(AssessmentCriteria::class, 'criteria_id');
    }

    /**
     * Get scores for this aspect
     */
    public function scores()
    {
        return $this->hasMany(InterviewAspectScore::class, 'aspect_id');
    }
}
