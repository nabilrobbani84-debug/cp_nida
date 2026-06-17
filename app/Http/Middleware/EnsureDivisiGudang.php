<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDivisiGudang
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->id_role === \App\Enums\RoleType::DivisiGudang->value) {
            return $next($request);
        }

        abort(403, 'Unauthorized action. Divisi Gudang only.');
    }
}
