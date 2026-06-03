<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminPusat
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->loadMissing('role')->isAdminPusat()) {
            abort(403, 'Akses ditolak. Hanya Admin Pusat yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}
