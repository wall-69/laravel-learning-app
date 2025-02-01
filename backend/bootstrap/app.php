<?php

use App\Http\Middleware\EnsureUserIsAdmin;
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

        // Return 403, if guests try to access routes that are not for guests
        $middleware->redirectGuestsTo(function () {
            return abort(response()->json([
                "message" => "You need to be authenticated in order to do this."
            ], 403));
        });
        // Do the same for logged in users
        $middleware->redirectUsersTo(function () {
            return abort(response()->json([
                "message" => "You can't do this."
            ], 403));
        });

        // Aliases
        $middleware->alias([
            "admin" => EnsureUserIsAdmin::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
