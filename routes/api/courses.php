<?php

use App\Http\Controllers\CourceController;
use Illuminate\Support\Facades\Route;

Route::post('courses/create', [CourceController::class, 'addCource']);
Route::get('courses/find', [CourceController::class, 'getAllCources']); 
Route::get('courses/find/{id}', [CourceController::class, 'getCource']); 
Route::get('courses/instructore', [CourceController::class, 'getInstructoreCources']);
