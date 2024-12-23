<?php


use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Book\BookController;
use App\Http\Controllers\Card\CardController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Comment\CommentController;
use App\Http\Controllers\ContactUs\ContactUsController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Exam\ExamBankController;
use App\Http\Controllers\Exam\ExamController;
use App\Http\Controllers\Lesson\LessonController;
use App\Http\Controllers\Lesson\LessonNoteController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Package\PackageController;
use App\Http\Controllers\Quiz\QuizController;
use App\Http\Controllers\Subscription\SubscriptionController;
use App\Http\Controllers\Teacher\TeacherController;
use Illuminate\Support\Facades\Route;


Route::middleware(['set-language'])->group(function () {
    Route::controller(UserAuthController::class)->group(function (){
        Route::post('/register','register');
        Route::post('/verify-email','verifyEmail');
        Route::middleware(['auth:sanctum'])->group(function () {
            Route::post('/change-password','changePassword');
            Route::post('/logout','logout');
        });
    });

});
Route::post('/books/guest', [BookController::class, 'getBooksByIds']);
Route::post('/guest/checkout', [OrderController::class, 'createOrder']);

Route::middleware(['auth:sanctum'])->group(function () {
//cart
    Route::post('cart/add-course/{courseId}', [CartController::class, 'addCourseToCart']);
    Route::post('cart/add-book/{bookId}', [CartController::class, 'addBookToCart']);
    Route::post('cart/add-package/{packageId}', [CartController::class, 'addPackageToCart']);

    Route::post('cart/book/increase/{bookId}', [CartController::class, 'increaseBookQuantity']);
    Route::post('cart/book/decrease/{bookId}', [CartController::class, 'decreaseBookQuantity']);

    Route::post('cart/book/remove/{bookId}', [CartController::class, 'removeBookFromCart']);
    Route::post('cart/course/remove/{courseId}', [CartController::class, 'removeCourseFromCart']);
    Route::post('cart/package/remove/{packageId}', [CartController::class, 'removePackageFromCart']);

    Route::get('/cart', [CartController::class, 'viewCart']);

    Route::post('/checkout', [OrderController::class, 'checkout']);
//quiz
    Route::get('quiz/{quiz}', [QuizController::class, 'getQuestion']);
    Route::post('quiz/{quiz}/question/{question}/submit', [QuizController::class, 'submitAnswer']);
    Route::post('quiz/{quiz}/question/{question}/self-assessment', [QuizController::class, 'submitSelfAssessmentScore']);
    Route::get('quiz/{quiz}/question/{currentQuestion}/next', [QuizController::class, 'getNextQuestion']);
    Route::get('quiz/{quiz}/score', [QuizController::class, 'getScore']);
});
//courses
Route::get('courses', [CourseController::class, 'index']);
Route::get('courses/by-grade-ids', [CourseController::class, 'getCoursesByGradeIds']);
Route::get('courses/names', [CourseController::class, 'getFilteredCourseNames']);
Route::get('courses/{course}', [CourseController::class, 'getCourse']);
Route::get('courses/{course}/lessons-with-quiz', [CourseController::class, 'getLessonsWithQuiz']);
Route::get('courses/{course}/lessons-with-cards', [CourseController::class, 'getLessonsWithCards']);
Route::get('course/{course}/details', [CourseController::class, 'showCourseDetails'])->middleware('auth.optional');

//lessons
Route::get('lessons/{lesson}', [LessonController::class, 'show'])->middleware('auth.optional');
Route::get('/lesson-note/download/{lesson}', [LessonController::class, 'download']);
Route::get('/cards/lesson/{lesson}', [CardController::class, 'get']);
Route::post('/cards/{card}/save', [CardController::class, 'save']);
Route::post('/cards/{card}/forget', [CardController::class, 'forget']);
Route::get('/lesson/{lesson}/score', [CardController::class, 'calculateScore']);

//comments
Route::get('/lessons/{lesson}/comments', [CommentController::class, 'showComments']);
Route::post('/lessons/{lesson}/comments', [CommentController::class, 'store']);
Route::post('/comments/{comment}', [CommentController::class, 'update']);
Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);

//books
Route::get('books', [BookController::class, 'index']);
Route::get('book/{book}/download', [BookController::class, 'download']);

//packages
Route::get('/packages', [PackageController::class, 'filteredPackages']);

//exams
Route::get('/course/{courseId}/exams', [ExamController::class, 'getExamsForCourse']);
Route::get('exams/{exam}/download/{fileType}', [ExamController::class, 'download']);

//examBanks
Route::get('/course/{courseId}/exam-banks', [ExamBankController::class, 'getBanksByCourse']);
Route::get('exam-banks/{examBank}/download/{fileType}', [ExamBankController::class, 'download']);

//teachers
Route::prefix('teachers')->group(function () {
    Route::get('/', [TeacherController::class, 'index']);
    Route::get('{teacher}', [TeacherController::class, 'show']);
});

//contact us
Route::post('contact-us', [ContactUsController::class, 'create']);




