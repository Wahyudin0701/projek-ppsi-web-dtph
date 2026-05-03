<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAccountIsApproved
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && !auth()->user()->isAdmin() && !auth()->user()->isApproved()) {
            if ($request->routeIs('dashboard')) {
                return $next($request);
            }
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
