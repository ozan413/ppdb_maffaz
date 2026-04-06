<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        $userRole = $user->role?->name;

        if (!in_array($userRole, $roles)) {
            // Redirect to appropriate dashboard based on role
            return $this->redirectToDashboard($userRole);
        }

        return $next($request);
    }

    /**
     * Redirect user to their appropriate dashboard
     */
    protected function redirectToDashboard(?string $role): Response
    {
        return match($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'panitia' => redirect()->route('panitia.dashboard'),
            'ustad' => redirect()->route('ustad.dashboard'),
            'santri' => redirect()->route('santri.dashboard'),
            default => redirect()->route('home'),
        };
    }
}
