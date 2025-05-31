<?php

use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::prefix('reviews')->group(function () {
    Route::get('/find', [ReviewController::class, 'getAll'])->name('reviews.getAll')->middleware('auth:api')->middleware('role:instructor,admin');;
    Route::post('/find', [ReviewController::class, 'createReview'])->name('reviews.create')->middleware('auth:api')->middleware('role:instructor,admin');;
    Route::get('/find/{id}', [ReviewController::class, 'getOne'])->name('reviews.getOne')->middleware('auth:api');
    Route::get('/find/course/{id}', [ReviewController::class, 'getReviewByCource'])->name('reviews.getcourseQuiz')->middleware('auth:api');
    Route::put('/find/{id}', [ReviewController::class, 'updateReview'])->name('reviews.update')->middleware('auth:api');
    Route::delete('/find/{id}', [ReviewController::class, 'deleteReview'])->name('reviews.delete')->middleware('auth:api')->middleware('role:instructor,admin');;
});
