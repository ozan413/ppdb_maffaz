<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Registration;
use App\Models\DataLilAthfal;
use App\Models\DataIddahTahfidz;
use App\Models\DataPaudqu;
use App\Models\DaftarUlangLilAthfal;
use App\Models\DaftarUlangIddahTahfidz;
use App\Models\DaftarUlangPaudqu;
use Illuminate\Support\Facades\Hash;

class KelolaSantriController extends Controller
{
    /**
     * Display list of all santri
     */
    public function index(Request $request)
    {
        $query = User::byRole('santri')
            ->with(['registration.program', 'registration.graduationDecision']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('program_id')) {
            $query->whereHas('registration', fn($q) => $q->where('program_id', $request->program_id));
        }

        $santris = $query->latest()->paginate(20);
        $programs = \App\Models\Program::all();

        return view('admin.kelola-santri.index', compact('santris', 'programs'));
    }

    /**
     * Show detail of a santri for editing
     */
    public function show($id)
    {
        $user = User::with(['registration.program'])->findOrFail($id);
        $registration = $user->registration;

        // Get program data
        $programData = null;
        $programType = null;
        if ($registration) {
            $slug = strtolower(str_replace([' ', '-'], '_', $registration->program->slug ?? $registration->program->name));
            
            if (str_contains($slug, 'lil_athfal') || str_contains($slug, 'athfal')) {
                $programData = DataLilAthfal::where('registration_id', $registration->id)->first();
                $programType = 'lil_athfal';
            } elseif (str_contains($slug, 'iddah') || str_contains($slug, 'tahfidz')) {
                $programData = DataIddahTahfidz::where('registration_id', $registration->id)->first();
                $programType = 'iddah_tahfidz';
            } elseif (str_contains($slug, 'paud') || str_contains($slug, 'paudqu')) {
                $programData = DataPaudqu::where('registration_id', $registration->id)->first();
                $programType = 'paudqu';
            }
        }

        // Get daftar ulang data
        $daftarUlang = null;
        $daftarUlangType = null;
        if ($registration) {
            $daftarUlang = DaftarUlangLilAthfal::where('registration_id', $registration->id)->first();
            if ($daftarUlang) $daftarUlangType = 'lil_athfal';
            
            if (!$daftarUlang) {
                $daftarUlang = DaftarUlangIddahTahfidz::where('registration_id', $registration->id)->first();
                if ($daftarUlang) $daftarUlangType = 'iddah_tahfidz';
            }
            
            if (!$daftarUlang) {
                $daftarUlang = DaftarUlangPaudqu::where('registration_id', $registration->id)->first();
                if ($daftarUlang) $daftarUlangType = 'paudqu';
            }
        }

        return view('admin.kelola-santri.show', compact('user', 'registration', 'programData', 'programType', 'daftarUlang', 'daftarUlangType'));
    }

    /**
     * Update user account data
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->filled('password')) {
            $user->password = $request->password; // Auto-hashed by User model cast
        }
        
        $user->save();

        return back()->with('success', 'Data akun berhasil diperbarui!');
    }

    /**
     * Update biodata program
     */
    public function updateBiodata(Request $request, $id)
    {
        $user = User::with('registration')->findOrFail($id);
        $registration = $user->registration;
        
        if (!$registration) {
            return back()->with('error', 'Registration tidak ditemukan.');
        }

        $slug = strtolower(str_replace([' ', '-'], '_', $registration->program->slug ?? $registration->program->name));
        
        if (str_contains($slug, 'lil_athfal') || str_contains($slug, 'athfal')) {
            $data = DataLilAthfal::where('registration_id', $registration->id)->first();
        } elseif (str_contains($slug, 'iddah') || str_contains($slug, 'tahfidz')) {
            $data = DataIddahTahfidz::where('registration_id', $registration->id)->first();
        } elseif (str_contains($slug, 'paud') || str_contains($slug, 'paudqu')) {
            $data = DataPaudqu::where('registration_id', $registration->id)->first();
        }

        if ($data) {
            $data->update($request->except(['_token', '_method']));
            return back()->with('success', 'Data biodata berhasil diperbarui!');
        }

        return back()->with('error', 'Data biodata tidak ditemukan.');
    }

    /**
     * Update daftar ulang data
     */
    public function updateDaftarUlang(Request $request, $id)
    {
        $user = User::with('registration')->findOrFail($id);
        $registration = $user->registration;
        
        if (!$registration) {
            return back()->with('error', 'Registration tidak ditemukan.');
        }

        $daftarUlang = DaftarUlangLilAthfal::where('registration_id', $registration->id)->first();
        if (!$daftarUlang) {
            $daftarUlang = DaftarUlangIddahTahfidz::where('registration_id', $registration->id)->first();
        }
        if (!$daftarUlang) {
            $daftarUlang = DaftarUlangPaudqu::where('registration_id', $registration->id)->first();
        }

        if ($daftarUlang) {
            $daftarUlang->update($request->except(['_token', '_method']));
            return back()->with('success', 'Data daftar ulang berhasil diperbarui!');
        }

        return back()->with('error', 'Data daftar ulang tidak ditemukan.');
    }
}
