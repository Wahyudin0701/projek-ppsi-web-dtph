<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'approved'   => \App\Http\Middleware\EnsureAccountIsApproved::class,
            'admin'      => \App\Http\Middleware\EnsureUserIsAdmin::class,
            'pimpinan'   => \App\Http\Middleware\EnsureUserIsPimpinan::class,
            'kabid'      => \App\Http\Middleware\EnsureUserIsKabid::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
