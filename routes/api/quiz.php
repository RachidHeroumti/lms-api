<?php

use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

Route::prefix('quizzes')->group(function () {
    Route::get('/', [QuizController::class, 'getAll'])->name('quizzes.getAll')->middleware('auth:api')->middleware('role:instructor,admin');;
    Route::post('/', [QuizController::class, 'createQuiz'])->name('quizzes.create')->middleware('auth:api')->middleware('role:instructor,admin');;
    Route::get('{id}', [QuizController::class, 'getOne'])->name('quizzes.getOne')->middleware('auth:api');
    Route::put('{id}', [QuizController::class, 'updateQuiz'])->name('quizzes.update')->middleware('auth:api')->middleware('role:instructor,admin');;
    Route::delete('{id}', [QuizController::class, 'deleteQuiz'])->name('quizzes.delete')->middleware('auth:api')->middleware('role:instructor,admin');;
});
