<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\UserController;


Route::prefix('v1')->group(function () {
    // Public Routes 
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);

    // Protected Routes 
    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('users', UserController::class);
        Route::post('/logout', [UserController::class, 'logout']);
    });
});
