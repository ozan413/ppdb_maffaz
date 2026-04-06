<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\InterviewSchedule;
use App\Models\GraduationDecision;

class DashboardController extends Controller
{
    /**
     * Show panitia dashboard
     */
    public function index()
    {
        $stats = [
            'total_paid' => Registration::where('payment_status', 'paid')->count(),
            'awaiting_schedule' => Registration::where('payment_status', 'paid')
                ->whereDoesntHave('interviewSchedule')
                ->count(),
            'scheduled' => InterviewSchedule::where('status', 'scheduled')->count(),
            'completed' => InterviewSchedule::where('status', 'completed')->count(),
            'awaiting_decision' => Registration::where('payment_status', 'paid')
                ->whereHas('interviewSchedule', fn($q) => $q->where('status', 'completed'))
                ->whereDoesntHave('graduationDecision')
                ->count(),
            'passed' => GraduationDecision::where('is_lulus', true)->count(),
            'failed' => GraduationDecision::where('is_lulus', false)->count(),
        ];

        $recentRegistrations = Registration::with(['user', 'program'])
            ->where('payment_status', 'paid')
            ->latest()
            ->take(10)
            ->get();

        return view('panitia.dashboard', compact('stats', 'recentRegistrations'));
    }
}
