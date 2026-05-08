<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\UserController;
use Modules\User\Http\Controllers\RoleController;
use Modules\User\Http\Controllers\PermissionController;


Route::prefix('v1')->group(function () {
    // Public Routes 
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);

    // Protected Routes 
    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('users', UserController::class);
        Route::post('users/{id}/assign-role', [UserController::class, 'assignRole']);
        Route::post('users/{id}/remove-role', [UserController::class, 'removeRole']);
        Route::post('/logout', [UserController::class, 'logout']);

        // Roles Management
        Route::apiResource('roles', RoleController::class);
        Route::post('roles/{id}/assign-permissions', [RoleController::class, 'assignPermissions']);

        // Permissions Management
        Route::apiResource('permissions', PermissionController::class);
    });
});
