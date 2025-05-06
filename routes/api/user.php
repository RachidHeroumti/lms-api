<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
// Middleware registration should be done in the Kernel.php file, not here.
// Remove this line or move it to the appropriate location in Kernel.php.

// Authentication routes
Route::post('/auth/sign-up', [UserController::class, 'Register']);
Route::post('/auth/login', [UserController::class, 'Login']);

// Protected routes - require JWT authentication
Route::middleware(['auth:api',])->group(function () {
    Route::get('/users', [UserController::class, 'GetUsers'])->middleware('auth:api')->middleware('role:admin');
    Route::get('/users/{id}', [UserController::class, 'getUser'])->middleware('auth:api');
    Route::put('/users/{id}', [UserController::class, 'updateUser'])->middleware('auth:api');
});