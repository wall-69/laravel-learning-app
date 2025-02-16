<?php

use App\Http\Controllers\AdminController;
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
    Route::post("/login", "login")->name("login")->middleware("guest");
    Route::post("/logout", "logout")->name("logout")->middleware("auth:sanctum");
});

Route::controller(UserController::class)->name("users.")->group(function () {
    // General
    Route::post("/users", "store")->name("store"); // Because you want guests and also admins to create users

    // SPA

    Route::middleware("guest")->group(function () {
        // General

        // SPA
    });

    Route::middleware("auth:sanctum")->group(function () {
        // General
        Route::get("/user", "user")->name("user");
        Route::get("/user/{user}", "userById");

        Route::get("/users", "index")->name("index");
        Route::patch("/users/{user}", "update")->name("update");
        Route::delete("/users/{user}", "destroy")->name("destroy");

        // SPA
    });
});

Route::controller(AdminController::class)->name("admins.")->middleware(["auth:sanctum", "admin"])->group(function () {
    // General
    Route::get("/admin/{admin}", "adminById");

    Route::get("/admins", "index")->name("index");
    Route::post("/admins", "store")->name("store");
    Route::delete("/admins/{admin}", "destroy")->name("destroy");
});


Route::controller(WordPackController::class)->name("word-packs.")->middleware("auth:sanctum")->group(function () {
    // General
    Route::get("/word-packs", "index")->name("index");
    Route::post("/word-packs", "store")->name("store");
    // Route::patch("/word-packs/{wordpack}", "update")->name("update");
    Route::delete("/word-packs/{wordpack}", "destroy")->name("destroy");
});
