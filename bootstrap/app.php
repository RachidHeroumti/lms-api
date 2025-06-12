<?php

use App\Http\Middleware\CheckUserRole;
use App\Http\Middleware\CorsMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register custom middleware aliases
        $middleware->alias([
            'role' => CheckUserRole::class,
            'cors' => CorsMiddleware::class,
        ]);

        // Add CORS middleware to API routes
        $middleware->api(prepend: [
            CorsMiddleware::class,
        ]);

        // Add CORS middleware to web routes if needed
        $middleware->web(prepend: [
            CorsMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();