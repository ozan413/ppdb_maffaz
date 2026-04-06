<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\InterviewSchedule;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\InterviewScheduledMail;

class InterviewController extends Controller
{
    /**
     * Show interview scheduling page
     */
    public function index(Request $request)
    {
        // Get registrations that need interview scheduling
        $query = Registration::with(['user', 'program'])
            ->where('payment_status', 'paid')
            ->whereDoesntHave('interviewSchedule');

        if ($request->filled('program_id')) {
            $query->where('program_id', $request->program_id);
        }

        $registrations = $query->latest()->paginate(20);
        
        // Get available ustads
        $ustads = User::byRole('ustad')->active()->get();
        $programs = \App\Models\Program::all();

        return view('panitia.interview.schedule', compact('registrations', 'ustads', 'programs'));
    }

    /**
     * Schedule an interview
     */
    public function schedule(Request $request)
    {
        $request->validate([
            'registration_id' => 'required|exists:registrations,id',
            'ustad_id' => 'required|exists:users,id',
            'schedule_date' => 'required|date|after_or_equal:today',
            'schedule_time' => 'required',
            'media' => 'required|in:whatsapp,video_call,tatap_muka',
            'notes' => 'nullable|string',
        ]);

        // Verify ustad exists and has correct role
        $ustad = User::find($request->ustad_id);
        if (!$ustad->isUstad()) {
            return back()->withErrors(['ustad_id' => 'User yang dipilih bukan ustad.']);
        }

        // Check if registration already has a schedule
        $existing = InterviewSchedule::where('registration_id', $request->registration_id)->first();
        if ($existing) {
            return back()->withErrors(['registration_id' => 'Santri ini sudah dijadwalkan wawancara.']);
        }

        InterviewSchedule::create([
            'registration_id' => $request->registration_id,
            'ustad_id' => $request->ustad_id,
            'panitia_id' => auth()->id(),
            'schedule_date' => $request->schedule_date,
            'schedule_time' => $request->schedule_time,
            'media' => $request->media,
            'notes' => $request->notes,
            'status' => 'scheduled',
        ]);

        // Update registration status
        $registration = Registration::with(['user', 'program'])->find($request->registration_id);
        $registration->update(['status' => 'interview_scheduled']);

        // Send email notification to santri
        try {
            $schedule = InterviewSchedule::with(['registration.user', 'registration.program', 'ustad'])
                ->where('registration_id', $request->registration_id)
                ->first();
            
            if ($schedule && $registration->user->email) {
                Mail::to($registration->user->email)->send(new InterviewScheduledMail($schedule));
            }
        } catch (\Exception $e) {
            // Log error but don't fail the request
            \Log::error('Failed to send interview schedule email: ' . $e->getMessage());
        }

        return redirect()->route('panitia.interview.index')
            ->with('success', 'Jadwal wawancara berhasil dibuat! Email notifikasi telah dikirim.');
    }

    /**
     * Monitor scheduled interviews
     */
    public function monitor(Request $request)
    {
        $query = InterviewSchedule::with([
            'registration.user',
            'registration.program',
            'ustad',
            'panitia',
            'result.aspectScores.aspect'
        ]);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('ustad_id')) {
            $query->where('ustad_id', $request->ustad_id);
        }

        $schedules = $query->latest()->paginate(20);
        $ustads = User::byRole('ustad')->get();

        return view('panitia.interview.monitor', compact('schedules', 'ustads'));
    }
}
