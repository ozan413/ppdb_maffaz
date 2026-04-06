<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\HomepageSetting;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectToDashboard();
        }
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors([
                    'username' => 'Akun Anda tidak aktif. Silakan hubungi admin.',
                ]);
            }

            return $this->redirectToDashboard();
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->withInput($request->only('username', 'remember'));
    }

    /**
     * Show register form
     */
    public function showRegister()
    {
        if (!HomepageSetting::isPPDBOpen()) {
            return redirect()->route('home')
                ->with('error', 'Pendaftaran PPDB belum dibuka atau sudah ditutup.');
        }

        if (Auth::check()) {
            return $this->redirectToDashboard();
        }

        return view('auth.register');
    }

    /**
     * Handle register request (for santri only)
     */
    public function register(Request $request)
    {
        if (!HomepageSetting::isPPDBOpen()) {
            return redirect()->route('home')
                ->with('error', 'Pendaftaran PPDB belum dibuka atau sudah ditutup.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users|alpha_dash',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'username.unique' => 'Username sudah digunakan.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        // Get santri role
        $santriRole = Role::where('name', 'santri')->first();

        if (!$santriRole) {
            return back()->withErrors([
                'email' => 'Terjadi kesalahan sistem. Silakan coba lagi.',
            ]);
        }

        $user = User::create([
            'role_id' => $santriRole->id,
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password, // Will be hashed by model cast
            'is_active' => true,
        ]);

        Auth::login($user);

        return redirect()->route('santri.dashboard')
            ->with('success', 'Registrasi berhasil! Selamat datang di PPDB Maskanul Huffadz.');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    /**
     * Redirect to appropriate dashboard based on role
     */
    protected function redirectToDashboard()
    {
        $user = Auth::user();
        $role = $user->role?->name;

        return match($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'panitia' => redirect()->route('panitia.dashboard'),
            'ustad' => redirect()->route('ustad.dashboard'),
            'santri' => redirect()->route('santri.dashboard'),
            default => redirect()->route('home'),
        };
    }
}
