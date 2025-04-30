<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Authentication routes
Route::post('/auth/sign-up', [UserController::class, 'Register']);
Route::post('/auth/login', [UserController::class, 'Login']);

// Protected routes - require JWT authentication
Route::middleware('auth:api')->group(function () {
    Route::get('/users', [UserController::class, 'GetUsers']);
    Route::get('/users/{id}', [UserController::class, 'getUser']);
    Route::put('/users/{id}', [UserController::class, 'updateUser']);
    Route::get('/users/{id}/services', [UserController::class, 'getUserServices']);
});
