<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;

class PendaftarController extends Controller
{
    /**
     * Display list of paid registrations
     */
    public function index(Request $request)
    {
        $query = Registration::with(['user', 'program', 'interviewSchedule', 'graduationDecision'])
            ->where('payment_status', 'paid');

        // Filter by program
        if ($request->filled('program_id')) {
            $query->where('program_id', $request->program_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $registrations = $query->latest()->paginate(20);
        $programs = \App\Models\Program::all();

        return view('panitia.pendaftar.index', compact('registrations', 'programs'));
    }

    /**
     * Show detail of a registration
     */
    public function show($id)
    {
        $registration = Registration::with([
            'user', 
            'program', 
            'payment',
            'interviewSchedule.ustad',
            'interviewSchedule.result.aspectScores.aspect',
            'graduationDecision'
        ])->findOrFail($id);

        $programData = $registration->getProgramData();

        return view('panitia.pendaftar.show', compact('registration', 'programData'));
    }
}
