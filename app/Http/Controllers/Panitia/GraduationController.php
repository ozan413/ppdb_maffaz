<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\GraduationDecision;

class GraduationController extends Controller
{
    /**
     * Show graduation decision page
     */
    public function index(Request $request)
    {
        // Get registrations with completed interviews awaiting decision
        $query = Registration::with([
            'user',
            'program',
            'interviewSchedule.result.aspectScores.aspect',
            'graduationDecision'
        ])
        ->where('payment_status', 'paid')
        ->whereHas('interviewSchedule', function($q) {
            $q->where('status', 'completed');
        });

        // Filter by decision status
        if ($request->filled('decision')) {
            if ($request->decision === 'pending') {
                $query->whereDoesntHave('graduationDecision');
            } elseif ($request->decision === 'passed') {
                $query->whereHas('graduationDecision', fn($q) => $q->where('is_lulus', true));
            } elseif ($request->decision === 'failed') {
                $query->whereHas('graduationDecision', fn($q) => $q->where('is_lulus', false));
            }
        }

        if ($request->filled('program_id')) {
            $query->where('program_id', $request->program_id);
        }

        $registrations = $query->latest()->paginate(20);
        $programs = \App\Models\Program::all();

        return view('panitia.graduation', compact('registrations', 'programs'));
    }

    /**
     * Make graduation decision
     */
    public function decide(Request $request, $registrationId)
    {
        $request->validate([
            'is_lulus' => 'required|boolean',
            'notes' => 'nullable|string',
        ]);

        $registration = Registration::findOrFail($registrationId);

        // Check if registration has completed interview
        if (!$registration->interviewSchedule || $registration->interviewSchedule->status !== 'completed') {
            return back()->withErrors(['error' => 'Wawancara belum selesai.']);
        }

        // Check if decision already exists
        $existingDecision = GraduationDecision::where('registration_id', $registrationId)->first();

        if ($existingDecision) {
            $existingDecision->update([
                'is_lulus' => $request->boolean('is_lulus'),
                'notes' => $request->notes,
                'decided_at' => now(),
            ]);
        } else {
            GraduationDecision::create([
                'registration_id' => $registrationId,
                'panitia_id' => auth()->id(),
                'is_lulus' => $request->boolean('is_lulus'),
                'notes' => $request->notes,
                'decided_at' => now(),
            ]);
        }

        // Update registration status
        $status = $request->boolean('is_lulus') ? 'passed' : 'failed';
        $registration->update(['status' => $status]);

        return redirect()->route('panitia.graduation.index')
            ->with('success', 'Keputusan kelulusan berhasil disimpan!');
    }
}
