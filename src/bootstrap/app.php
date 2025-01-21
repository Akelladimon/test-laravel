<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        using: function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        },
        commands: __DIR__.'/../routes/console.php',
    )
//    ->withRouting(
//        web: __DIR__ . '/../routes/web.php',
//        commands: __DIR__ . '/../routes/console.php',
//        health: '/up',
//        then: function () {
//            Route::middleware('api')
//                ->prefix('webhooks')
//                ->name('webhooks.')
//                ->group(base_path('routes/webhooks.php'));
//        },
//    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
