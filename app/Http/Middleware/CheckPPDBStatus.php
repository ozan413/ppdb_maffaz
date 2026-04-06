<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\HomepageSetting;

class CheckPPDBStatus
{
    /**
     * Handle an incoming request.
     * Check if PPDB registration is open
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!HomepageSetting::isPPDBOpen()) {
            return redirect()->route('home')
                ->with('error', 'Pendaftaran PPDB belum dibuka atau sudah ditutup.');
        }

        return $next($request);
    }
}
