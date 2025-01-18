<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::controller(UserController::class)->name("users.")->group(function () {
    Route::get("/user", "user");

    Route::middleware("guest")->group(function () {
        Route::post("/users", "store");
    });

    Route::middleware("auth:sanctum")->group(function () {
    });
});
