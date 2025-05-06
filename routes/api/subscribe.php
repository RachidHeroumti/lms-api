<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscribeController;


Route::prefix('subscribe')->group(function () {
    Route::post('/checkout', [PaymentController::class, 'createPaymentIntent'])->name('subscribe.checkout')->middleware('auth:api');
    Route::post('/save-transaction', [SubscribeController::class, 'buyCourse'])->name('subscribe.create')->middleware('auth:api');
    Route::get('/student/{studentId}/courses', [SubscribeController::class, 'getStudentCourses'])->name('subscribe.student.courses')->middleware('auth:api');
    Route::get('/course/{courseId}/students', [SubscribeController::class, 'getCourseSubscribers'])->name('subscribe.course.students')->middleware('auth:api')->middleware('role:instructor,admin');
});
