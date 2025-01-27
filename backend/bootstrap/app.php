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
        // Stateful API
        $middleware->statefulApi();

        // TODO: fix pls
        // Return 403, if guests try to access routes that are not for guests
        $middleware->redirectGuestsTo(function () {
            return abort(403);
        });
        // Do the same for logged in users
        $middleware->redirectUsersTo(function () {
            return abort(403);
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
