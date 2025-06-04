<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscribeController;

Route::prefix('subscribe')
    ->middleware('auth:api')
    ->group(function () {

    Route::post('/', [SubscribeController::class, 'buyCourse'])
        ->name('subscribe.checkout');

    Route::get('/student/{studentId}/courses', [SubscribeController::class, 'getStudentCourses'])
        ->name('subscribe.student.courses');

    Route::middleware('role:instructor,admin')->group(function () {
        Route::get('/course/{courseId}/students', [SubscribeController::class, 'getCourseSubscribers'])
            ->name('subscribe.course.students');

        Route::get('/analytics/{courseId}/students', [SubscribeController::class, 'getAnalytics'])
            ->name('subscribe.analytics');
              Route::get('/pending-orders', [SubscribeController::class, 'PendingOrder'])->name('subscribe.pending_orders');

              Route::patch('/accepet-order/{id}', [SubscribeController::class, 'acceptPendingOrder'])
            ->name('subscribe.accepte_order');
               Route::delete('/delete/{id}', [SubscribeController::class, 'deleteSubscription'])
            ->name('subscribe.delete');
    });
});


// Route::prefix('subscribe')->group(function () {
//     Route::post('/checkout', [PaymentController::class, 'createPaymentIntent'])->name('subscribe.checkout')->middleware('auth:api');
//     Route::post('/save-transaction', [SubscribeController::class, 'buyCourse'])->name('subscribe.create')->middleware('auth:api');
//     Route::get('/student/{studentId}/courses', [SubscribeController::class, 'getStudentCourses'])->name('subscribe.student.courses')->middleware('auth:api');
//     Route::get('/course/{courseId}/students', [SubscribeController::class, 'getCourseSubscribers'])->name('subscribe.course.students')->middleware('auth:api')->middleware('role:instructor,admin');
// });