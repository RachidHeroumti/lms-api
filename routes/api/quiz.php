<?php

use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

Route::prefix('quizzes')->group(function () {
    Route::get('/', [QuizController::class, 'getAll'])->name('quizzes.getAll');
    Route::post('/', [QuizController::class, 'createQuiz'])->name('quizzes.create');
    Route::get('{id}', [QuizController::class, 'getOne'])->name('quizzes.getOne');
    Route::put('{id}', [QuizController::class, 'updateQuiz'])->name('quizzes.update');
    Route::delete('{id}', [QuizController::class, 'deleteQuiz'])->name('quizzes.delete');
});
