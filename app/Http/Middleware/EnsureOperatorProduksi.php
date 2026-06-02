<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOperatorProduksi
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user()?->loadMissing('role');

        if (! $user?->isOperatorProduksi()) {
            abort(403, 'Akses ditolak. Hanya Operator Produksi yang dapat mengakses halaman ini.');
        }

        if ($user->id_branch === null) {
            abort(403, 'Akun Anda tidak terhubung ke cabang. Hubungi administrator.');
        }

        return $next($request);
    }
}
