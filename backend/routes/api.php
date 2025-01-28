<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WordPackController;
use Illuminate\Support\Facades\Route;

/*
    Routes
    1. General API routes
    2. Web routes - SPA routes, stateful API, cookie based session authentication
    3. Mobile routes - IF there will be a mobile app, token based authentication
*/

Route::controller(AuthController::class)->name("auth.")->group(function () {
    // SPA
    Route::middleware("web")->group(function () {
        Route::post("/login", "login")->name("login")->middleware("guest");
        Route::post("/logout", "logout")->name("logout")->middleware("auth:sanctum");
    });
});

Route::controller(UserController::class)->name("users.")->group(function () {
    Route::middleware("guest")->group(function () {
        // General
        Route::post("/users", "store")->name("store");

        // SPA
    });

    Route::middleware("auth:sanctum")->group(function () {
        // General
        Route::get("/user", "user")->name("user");

        // SPA
    });
});

Route::controller(WordPackController::class)->name("word-packs.")->group(function () {
    Route::middleware("auth:sanctum")->group(function () {
        Route::post("/word-packs", "store")->name("store");
    });
});
