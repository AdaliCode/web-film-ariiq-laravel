<?php

use App\Exceptions\ValidationException;
use App\Http\Middleware\ExampleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // alias
        $middleware->alias(
            ['example' => ExampleMiddleware::class]
        );
        // group
        $middleware->group('aflix', ['example:AFLIX,401']); // alias : string $key, int $status
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->reportable(function (Throwable $e) {
            // var_dump($e);
        });
        $exceptions->dontReport(ValidationException::class);

        $exceptions->renderable(function (ValidationException $exception, Request $request) {
            return response("Bad Request", 400);
        });
    })->create();
