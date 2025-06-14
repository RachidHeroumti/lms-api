<?php

use App\Http\Controllers\CourceController;
use Illuminate\Support\Facades\Route;

Route::post('courses/create', [CourceController::class, 'addCource'])->middleware('auth:api')->middleware('role:instructor,admin');
Route::get('courses/find', [CourceController::class, 'getAllCources']); 
Route::get('courses/find/{id}', [CourceController::class, 'getCource']); 
Route::get('courses/find/instructor/{id}', [CourceController::class, 'getInstructorCourses'])->middleware('auth:api');
