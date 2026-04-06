<?php

namespace App\Http\Controllers\Santri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\InterviewSchedule;
use App\Models\GraduationDecision;

class DashboardController extends Controller
{
    /**
     * Show santri dashboard
     */
    public function index()
    {
        $user = auth()->user();
        $registration = Registration::with(['program', 'payment', 'interviewSchedule', 'graduationDecision'])
            ->where('user_id', $user->id)
            ->first();

        return view('santri.dashboard', compact('user', 'registration'));
    }

    /**
     * Show jadwal wawancara
     */
    public function jadwalWawancara()
    {
        $user = auth()->user();
        $registration = $user->registration;
        $schedule = null;

        if ($registration) {
            $schedule = InterviewSchedule::with(['ustad', 'result'])
                ->where('registration_id', $registration->id)
                ->first();
        }

        return view('santri.jadwal-wawancara', compact('schedule'));
    }

    /**
     * Show pengumuman (announcement)
     */
    public function pengumuman()
    {
        $user = auth()->user();
        $registration = $user->registration;
        $decision = null;

        if ($registration) {
            $decision = GraduationDecision::where('registration_id', $registration->id)->first();
        }

        return view('santri.pengumuman', compact('registration', 'decision'));
    }

    /**
     * Show daftar ulang page
     */
    public function daftarUlang()
    {
        $user = auth()->user();
        $registration = $user->registration;
        $decision = null;

        if ($registration) {
            $decision = GraduationDecision::where('registration_id', $registration->id)
                ->where('is_lulus', true)
                ->first();
        }

        return view('santri.daftar-ulang', compact('registration', 'decision'));
    }
}
