<?php

use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

Route::prefix('quizzes')->group(function () {
    Route::get('/find', [QuizController::class, 'getAll'])->name('quizzes.getAll')->middleware('auth:api')->middleware('role:instructor,admin');;
    Route::post('/find', [QuizController::class, 'createQuiz'])->name('quizzes.create')->middleware('auth:api')->middleware('role:instructor,admin');;
    Route::get('/find/{id}', [QuizController::class, 'getOne'])->name('quizzes.getOne')->middleware('auth:api');
    Route::get('/find/course/{id}', [QuizController::class, 'getQuizByCource'])->name('quizzes.getcourseQuiz')->middleware('auth:api');
    Route::put('/find/{id}', [QuizController::class, 'updateQuiz'])->name('quizzes.update')->middleware('auth:api')->middleware('role:instructor,admin');;
    Route::delete('/find/{id}', [QuizController::class, 'deleteQuiz'])->name('quizzes.delete')->middleware('auth:api')->middleware('role:instructor,admin');;
});
