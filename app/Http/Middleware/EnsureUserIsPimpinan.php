<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsPimpinan
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isPimpinan()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk Pimpinan.');
        }

        return $next($request);
    }
}
