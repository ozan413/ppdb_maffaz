<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssessmentCriteria;
use App\Models\AssessmentAspect;
use App\Models\HomepageSetting;

class AssessmentController extends Controller
{
    /**
     * Display assessment criteria management page
     */
    public function index(Request $request)
    {
        $academicYear = $request->get('year', HomepageSetting::getSettings()->academic_year ?? date('Y') . '/' . (date('Y') + 1));
        
        $criterias = AssessmentCriteria::with('aspects')
            ->where('academic_year', $academicYear)
            ->orderBy('order')
            ->get();

        // Get all available years
        $years = AssessmentCriteria::distinct()->pluck('academic_year')->toArray();
        if (!in_array($academicYear, $years)) {
            $years[] = $academicYear;
        }
        sort($years);

        return view('admin.assessment.index', compact('criterias', 'academicYear', 'years'));
    }

    /**
     * Store a new criteria
     */
    public function storeCriteria(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'academic_year' => 'required|string|max:20',
        ]);

        $maxOrder = AssessmentCriteria::where('academic_year', $request->academic_year)->max('order') ?? 0;

        AssessmentCriteria::create([
            'name' => $request->name,
            'academic_year' => $request->academic_year,
            'is_active' => true,
            'order' => $maxOrder + 1,
        ]);

        return redirect()->route('admin.assessment.index', ['year' => $request->academic_year])
            ->with('success', 'Kriteria berhasil ditambahkan!');
    }

    /**
     * Update criteria
     */
    public function updateCriteria(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $criteria = AssessmentCriteria::findOrFail($id);
        $criteria->update([
            'name' => $request->name,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.assessment.index', ['year' => $criteria->academic_year])
            ->with('success', 'Kriteria berhasil diperbarui!');
    }

    /**
     * Delete criteria
     */
    public function destroyCriteria($id)
    {
        $criteria = AssessmentCriteria::findOrFail($id);
        $year = $criteria->academic_year;
        $criteria->delete();

        return redirect()->route('admin.assessment.index', ['year' => $year])
            ->with('success', 'Kriteria berhasil dihapus!');
    }

    /**
     * Store a new aspect
     */
    public function storeAspect(Request $request)
    {
        $request->validate([
            'criteria_id' => 'required|exists:assessment_criterias,id',
            'name' => 'required|string|max:255',
        ]);

        $maxOrder = AssessmentAspect::where('criteria_id', $request->criteria_id)->max('order') ?? 0;

        AssessmentAspect::create([
            'criteria_id' => $request->criteria_id,
            'name' => $request->name,
            'order' => $maxOrder + 1,
        ]);

        $criteria = AssessmentCriteria::find($request->criteria_id);

        return redirect()->route('admin.assessment.index', ['year' => $criteria->academic_year])
            ->with('success', 'Aspek berhasil ditambahkan!');
    }

    /**
     * Update aspect
     */
    public function updateAspect(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $aspect = AssessmentAspect::findOrFail($id);
        $aspect->update(['name' => $request->name]);

        return redirect()->route('admin.assessment.index', ['year' => $aspect->criteria->academic_year])
            ->with('success', 'Aspek berhasil diperbarui!');
    }

    /**
     * Delete aspect
     */
    public function destroyAspect($id)
    {
        $aspect = AssessmentAspect::findOrFail($id);
        $year = $aspect->criteria->academic_year;
        $aspect->delete();

        return redirect()->route('admin.assessment.index', ['year' => $year])
            ->with('success', 'Aspek berhasil dihapus!');
    }

    /**
     * Copy criteria from one year to another
     */
    public function copyToYear(Request $request)
    {
        $request->validate([
            'from_year' => 'required|string',
            'to_year' => 'required|string|different:from_year',
        ]);

        $sourceCriterias = AssessmentCriteria::with('aspects')
            ->where('academic_year', $request->from_year)
            ->get();

        foreach ($sourceCriterias as $criteria) {
            $newCriteria = AssessmentCriteria::create([
                'name' => $criteria->name,
                'academic_year' => $request->to_year,
                'is_active' => $criteria->is_active,
                'order' => $criteria->order,
            ]);

            foreach ($criteria->aspects as $aspect) {
                AssessmentAspect::create([
                    'criteria_id' => $newCriteria->id,
                    'name' => $aspect->name,
                    'order' => $aspect->order,
                ]);
            }
        }

        return redirect()->route('admin.assessment.index', ['year' => $request->to_year])
            ->with('success', 'Kriteria berhasil disalin ke tahun ' . $request->to_year);
    }
}
