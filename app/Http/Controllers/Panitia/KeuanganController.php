<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Payment;
use App\Models\Program;

class KeuanganController extends Controller
{
    /**
     * Display finance dashboard
     */
    public function index(Request $request)
    {
        // Get all paid registrations
        $query = Registration::with(['user', 'program', 'payment'])
            ->where('payment_status', 'paid');

        // Filter by program
        if ($request->filled('program_id')) {
            $query->where('program_id', $request->program_id);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereHas('payment', fn($q) => $q->whereDate('paid_at', '>=', $request->start_date));
        }
        if ($request->filled('end_date')) {
            $query->whereHas('payment', fn($q) => $q->whereDate('paid_at', '<=', $request->end_date));
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"));
        }

        $payments = $query->latest()->paginate(20);
        $programs = Program::all();

        // Statistics
        $stats = [
            'total_paid' => Registration::where('payment_status', 'paid')->count(),
            'total_pending' => Registration::where('payment_status', 'pending')->count(),
            'total_amount' => Payment::sum('amount') ?: 0,
            'this_month' => Payment::whereMonth('paid_at', now()->month)->whereYear('paid_at', now()->year)->sum('amount') ?: 0,
        ];

        // Payment per program
        $paymentByProgram = Registration::where('payment_status', 'paid')
            ->selectRaw('program_id, COUNT(*) as count')
            ->groupBy('program_id')
            ->with('program')
            ->get();

        return view('panitia.keuangan.index', compact('payments', 'programs', 'stats', 'paymentByProgram'));
    }
}
