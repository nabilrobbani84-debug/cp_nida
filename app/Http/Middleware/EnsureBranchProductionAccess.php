<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureBranchProductionAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user()?->loadMissing('role');

        if (! $user?->canAccessBranchProduction()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk Operator Produksi atau Kepala Cabang.');
        }

        if ($user->id_branch === null) {
            abort(403, 'Akun Anda tidak terhubung ke cabang. Hubungi administrator.');
        }

        return $next($request);
    }
}
