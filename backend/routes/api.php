<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::controller(UserController::class)->name("users.")->group(function () {
    Route::middleware("guest")->group(function () {
        Route::post("/login", "authenticate")->name("authenticate");

        Route::post("/users", "store")->name("store");
    });

    Route::middleware("auth:sanctum")->group(function () {
        Route::get("/user", "user")->name("user");

        Route::post("/logout", "logout")->name("logout");
    });
});
