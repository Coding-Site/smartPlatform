<?php


use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Book\BookController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Subscription\SubscriptionController;
use App\Http\Controllers\Teacher\TeacherController;
use Illuminate\Support\Facades\Route;


Route::middleware(['set-language'])->group(function () {
    Route::controller(UserAuthController::class)->group(function (){
        Route::post('/register','register');
        Route::post('/verify-email','verifyEmail');
        Route::post('/login','login');
        Route::post('/forgot-password','forgotPassword');
        Route::post('/reset-password','resetPassword');

        Route::middleware(['auth:sanctum'])->group(function () {
            Route::post('/change-password','changePassword');
            Route::post('/logout','logout');
        });
    });

});

Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('cart/add-course/{courseId}', [CartController::class, 'addCourseToCart']);
    Route::post('cart/add-book/{bookId}', [CartController::class, 'addBookToCart']);

    Route::post('cart/book/increase/{bookId}', [CartController::class, 'increaseBookQuantity']);
    Route::post('cart/book/decrease/{bookId}', [CartController::class, 'decreaseBookQuantity']);

    Route::post('cart/book/remove/{bookId}', [CartController::class, 'removeBookFromCart']);
    Route::post('cart/course/remove/{courseId}', [CartController::class, 'removeCourseFromCart']);

    Route::get('/cart', [CartController::class, 'viewCart']);

    Route::post('/checkout', [OrderController::class, 'checkout']);

    Route::apiResource('books', BookController::class)->only('index','show');
    Route::get('book/{book}/download', [BookController::class, 'download']);

    Route::prefix('teachers')->group(function () {
        Route::get('/', [TeacherController::class, 'index']);
        Route::get('{teacher}', [TeacherController::class, 'show']);
    });
});

Route::get('course/{course}/details', [CourseController::class, 'showCourseDetails'])->middleware('auth.optional');

