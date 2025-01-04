<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Add middleware if required
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Handle validation exceptions globally
        $exceptions->render(function (\Illuminate\Validation\ValidationException $exception, $request) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors occurred.',
                'errors' => $exception->errors(),
            ], 422);
        });

        // Handle other exception types here if necessary
    })
    ->create();
