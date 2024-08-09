<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Spatie\Permission\Middleware\PermissionMiddleware as MiddlewarePermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware as MiddlewareRoleMiddleware;
use Spatie\Permission\Middlewares\RoleMiddleware;
use Spatie\Permission\Middlewares\PermissionMiddleware;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        // Global middleware
        \App\Http\Middleware\HandleCors::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        // Other middleware...
        'checkRole' => \App\Http\Middleware\CheckRole::class,
        'permission' => MiddlewarePermissionMiddleware::class,
        'cors' => \App\Http\Middleware\HandleCors::class,
    ];

    protected $middlewareGroups = [
        'web' => [
            // Otros middlewares
            \App\Http\Middleware\HandleCors::class,
        ],

        'api' => [
            // Otros middlewares
            \App\Http\Middleware\HandleCors::class,
        ],
    ];

}
