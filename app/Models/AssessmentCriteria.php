<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentCriteria extends Model
{
    use HasFactory;

    protected $table = 'assessment_criterias';

    protected $fillable = [
        'name',
        'academic_year',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get aspects for this criteria
     */
    public function aspects()
    {
        return $this->hasMany(AssessmentAspect::class, 'criteria_id')->orderBy('order');
    }

    /**
     * Scope for active criterias
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope by academic year
     */
    public function scopeForYear($query, $year)
    {
        return $query->where('academic_year', $year);
    }

    /**
     * Get current active criterias
     */
    public static function getCurrentCriterias()
    {
        $currentYear = HomepageSetting::getSettings()->academic_year ?? date('Y') . '/' . (date('Y') + 1);
        return static::active()->forYear($currentYear)->orderBy('order')->with('aspects')->get();
    }
}
