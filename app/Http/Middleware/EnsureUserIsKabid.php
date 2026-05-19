<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsKabid
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isKabid()) {
            abort(403, 'Akses hanya untuk Kepala Bidang.');
        }

        return $next($request);
    }
}
