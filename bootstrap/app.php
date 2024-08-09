<?php

use App\Http\Middleware\CheckRole;
use App\Http\Middleware\LoginIsValid;
use App\Http\Middleware\CheckSSO;
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
        $middleware->alias([
            'subscribed' => LoginIsValid::class,
            'check.sso' => CheckSSO::class,
            'checkRole' => CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
