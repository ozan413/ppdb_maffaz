<?php

namespace App\Http\Controllers\Ustad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InterviewSchedule;
use App\Models\InterviewResult;
use App\Models\InterviewAspectScore;
use App\Models\AssessmentCriteria;

class InterviewController extends Controller
{
    /**
     * Show list of assigned interviews
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = InterviewSchedule::with(['registration.user', 'registration.program', 'result'])
            ->where('ustad_id', $user->id)
            ->where('status', 'scheduled');

        if ($request->filled('date')) {
            $query->whereDate('schedule_date', $request->date);
        }

        $schedules = $query->orderBy('schedule_date', 'asc')
            ->orderBy('schedule_time', 'asc')
            ->paginate(20);

        // Load program data to get phone numbers
        foreach ($schedules as $schedule) {
            $schedule->programData = $schedule->registration->getProgramData();
        }

        return view('ustad.interview-schedule', compact('schedules'));
    }

    /**
     * Show interview detail for grading
     */
    public function show($id)
    {
        $user = auth()->user();

        $schedule = InterviewSchedule::with([
            'registration.user',
            'registration.program',
            'registration.graduationDecision',
            'result.aspectScores.aspect.criteria'
        ])
        ->where('ustad_id', $user->id)
        ->findOrFail($id);

        $programData = $schedule->registration->getProgramData();
        
        // Get current active criteria with aspects
        $criterias = AssessmentCriteria::getCurrentCriterias();
        
        // Get existing scores if any
        $existingScores = [];
        if ($schedule->result) {
            foreach ($schedule->result->aspectScores as $score) {
                $existingScores[$score->aspect_id] = $score->score;
            }
        }

        // Can edit if no graduation decision has been made yet
        $canEdit = !$schedule->registration->graduationDecision;

        return view('ustad.interview-detail', compact('schedule', 'programData', 'criterias', 'existingScores', 'canEdit'));
    }

    /**
     * Store interview result
     */
    public function storeResult(Request $request, $id)
    {
        $user = auth()->user();

        $schedule = InterviewSchedule::with('registration.graduationDecision')
            ->where('ustad_id', $user->id)
            ->findOrFail($id);

        // Check if graduation decision already made
        if ($schedule->registration->graduationDecision) {
            return back()->withErrors(['error' => 'Nilai tidak dapat diubah karena keputusan kelulusan sudah diberikan.']);
        }

        $request->validate([
            'catatan_orang_tua' => 'nullable|string',
            'nilai_tahfidz' => 'nullable|integer|min:0|max:100',
            'nilai_tahsin' => 'nullable|integer|min:0|max:100',
            'nilai_bahasa_arab' => 'nullable|integer|min:0|max:100',
            'nilai_tajwid' => 'nullable|integer|min:0|max:100',
            'catatan_ustad' => 'nullable|string',
            'aspect_scores' => 'nullable|array',
            'aspect_scores.*' => 'nullable|in:A,B,C,D',
        ]);

        // Create or update result
        $result = InterviewResult::updateOrCreate(
            ['interview_schedule_id' => $schedule->id],
            [
                'catatan_orang_tua' => $request->catatan_orang_tua,
                'nilai_tahfidz' => $request->nilai_tahfidz,
                'nilai_tahsin' => $request->nilai_tahsin,
                'nilai_bahasa_arab' => $request->nilai_bahasa_arab,
                'nilai_tajwid' => $request->nilai_tajwid,
                'catatan_ustad' => $request->catatan_ustad,
            ]
        );

        // Save aspect scores
        if ($request->has('aspect_scores')) {
            foreach ($request->aspect_scores as $aspectId => $score) {
                if ($score) {
                    InterviewAspectScore::updateOrCreate(
                        [
                            'interview_result_id' => $result->id,
                            'aspect_id' => $aspectId,
                        ],
                        ['score' => $score]
                    );
                }
            }
        }

        // Update schedule status
        $schedule->update(['status' => 'completed']);

        // Update registration status
        $schedule->registration->update(['status' => 'interviewed']);

        return redirect()->route('ustad.interview.index')
            ->with('success', 'Nilai wawancara berhasil disimpan!');
    }

    /**
     * Show completed interviews
     */
    public function completed(Request $request)
    {
        $user = auth()->user();

        $schedules = InterviewSchedule::with([
            'registration.user',
            'registration.program',
            'registration.graduationDecision',
            'result.aspectScores.aspect'
        ])
        ->where('ustad_id', $user->id)
        ->where('status', 'completed')
        ->latest()
        ->paginate(20);

        return view('ustad.interview-completed', compact('schedules'));
    }
}
