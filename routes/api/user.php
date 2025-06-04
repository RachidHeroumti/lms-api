<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/sign-up', [UserController::class, 'Register']);
Route::post('/auth/login', [UserController::class, 'Login']);


Route::middleware(['auth:api'])->group(function () {
    Route::get('/users', [UserController::class, 'GetUsers'])->middleware('role:admin');
    Route::get('/users/me', [UserController::class, 'getMe']);
    Route::get('/users/{id}', [UserController::class, 'getUser']);
    Route::put('/users/{id}', [UserController::class, 'updateUser']);
    
});
