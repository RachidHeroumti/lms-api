<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscribeController;


Route::prefix('subscribe')->group(function () {
    Route::post('/', [SubscribeController::class, 'buyCourse'])->name('subscribe.create');
    Route::get('/student/{studentId}/courses', [SubscribeController::class, 'getStudentCourses'])->name('subscribe.student.courses');
    Route::get('/course/{courseId}/students', [SubscribeController::class, 'getCourseSubscribers'])->name('subscribe.course.students');
});
