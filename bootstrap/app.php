<?php

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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->prependToGroup('api', [\Illuminate\Http\Middleware\PrefersJsonResponses::class]);

        // FITUR WAJIB #4 - SECURITY IMPROVEMENT
        // Mengonfigurasi pengecualian CSRF (di belakang layar ini menggunakan PreventRequestForgery)
        $middleware->validateCsrfTokens(except: [
            'api/*', // Mengecualikan rute API dari perlindungan CSRF karena API menggunakan otentikasi token (Sanctum)
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
