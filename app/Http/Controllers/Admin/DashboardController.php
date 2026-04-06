<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Registration;
use App\Models\Program;
use App\Models\HomepageSetting;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function index()
    {
        $stats = [
            'total_santri' => User::byRole('santri')->count(),
            'total_registrations' => Registration::count(),
            'paid_registrations' => Registration::where('payment_status', 'paid')->count(),
            'pending_registrations' => Registration::where('payment_status', 'pending')->count(),
            'total_programs' => Program::count(),
            'ppdb_status' => HomepageSetting::isPPDBOpen(),
        ];

        $recentRegistrations = Registration::with(['user', 'program'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentRegistrations'));
    }
}
