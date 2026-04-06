<?php

namespace App\Http\Controllers\Ustad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InterviewSchedule;

class DashboardController extends Controller
{
    /**
     * Show ustad dashboard
     */
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'total_scheduled' => InterviewSchedule::where('ustad_id', $user->id)
                ->where('status', 'scheduled')
                ->count(),
            'completed' => InterviewSchedule::where('ustad_id', $user->id)
                ->where('status', 'completed')
                ->count(),
            'today' => InterviewSchedule::where('ustad_id', $user->id)
                ->where('schedule_date', today())
                ->where('status', 'scheduled')
                ->count(),
        ];

        $upcomingSchedules = InterviewSchedule::with(['registration.user', 'registration.program'])
            ->where('ustad_id', $user->id)
            ->where('status', 'scheduled')
            ->orderBy('schedule_date', 'asc')
            ->orderBy('schedule_time', 'asc')
            ->take(10)
            ->get();

        return view('ustad.dashboard', compact('stats', 'upcomingSchedules'));
    }
}
