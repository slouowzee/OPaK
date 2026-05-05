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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*P');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $logPath = dirname(__DIR__) . '/storage/logs/error.log';
        $exceptions->report(function (\Throwable $e) use ($logPath) {
            file_put_contents(
                $logPath,
                date('Y-m-d H:i:s') . ' - ' . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n\n",
                FILE_APPEND
            );
        });
    })->create();
