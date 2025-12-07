<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // keep stateful API support (Sanctum)
        $middleware->statefulApi();

        // Exclude API routes from CSRF validation (use token-based or Sanctum flow for APIs)
        $middleware->validateCsrfTokens(except: [
            'api/*',
        ]);

        // Register custom middleware aliases
        $middleware->alias([
            'auth.api' => \App\Http\Middleware\ApiTokenAuth::class,
            'admin'    => \App\Http\Middleware\IsAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
