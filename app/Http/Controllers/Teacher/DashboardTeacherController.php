<?php

namespace App\Http\Controllers\Teacher;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Teacher\RegisterRequest;
use App\Http\Requests\Auth\Teacher\UpdateTeacherRequest;
use App\Models\Course\Course;
use App\Models\Subscription\Subscription;
use App\Models\Teacher\Teacher;
use App\Models\Teacher\Walet;
use App\Repositories\Auth\TeacherAuthRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DashboardTeacherController extends Controller
{

    protected $authRepository;

    public function __construct(TeacherAuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }
    public function index()
    {
        try {
            $teachers = Teacher::all();
            return ApiResponse::sendResponse(200, 'Teachers retrieved successfully', $teachers);
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Unable to fetch teachers. ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $teacher = Teacher::findOrFail($id);
            return ApiResponse::sendResponse(200, 'Teacher retrieved successfully', $teacher);
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Unable to fetch teacher. ' . $e->getMessage());
        }
    }


    public function store(RegisterRequest $request)
    {
        DB::beginTransaction();

        try {
            $teacher = $this->authRepository->createTeacher($request->validated());
            $teacher->assignRole('super_teacher');
            $walet = new Walet([
                'final_profit' => 0.00,
            ]);
            $teacher->walet()->save($walet);
            DB::commit();

            return ApiResponse::sendResponse(201, 'Teacher created and assigned role successfully', $teacher);
        } catch (Exception $e) {
            DB::rollBack();

            return ApiResponse::sendResponse(500, 'Unable to create teacher. ' . $e->getMessage());
        }
    }

    public function update(UpdateTeacherRequest $request, $id)
    {


        try {
            $teacher = Teacher::findOrFail($id);

            $teacher->update($request->only([
                'name', 'email', 'phone', 'course_id', 'stage_id', 'bio',
            ]));

            return ApiResponse::sendResponse(200, 'Teacher updated successfully', $teacher);
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Unable to update teacher. ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $teacher = Teacher::findOrFail($id);
            $teacher->delete();
            return ApiResponse::sendResponse(200, 'Teacher deleted successfully');
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Unable to delete teacher. ' . $e->getMessage());
        }
    }

    public function getCourseSubscription()  //  اشتراكات الطلبة في المواد
    {
        $teacher = Auth::guard('teacher')->user();
        $subscribedCourses = $teacher->courses()
            ->whereHas('subscriptions')
            ->with(['subscriptions.user', 'grade', 'stage'])
            ->get();

        $result = $subscribedCourses->flatMap(function ($course) {
            return $course->subscriptions->map(function ($subscription) use ($course) {
                return [
                    'course'            => $course->name,
                    'grade'             => $course->grade->name,
                    'user'              => $subscription->user->name,
                    'subscription_type' => $subscription->subscription_type === 'per_month'
                        ? ' per_month'
                        : ' per_semester',
                ];
            });
        });
        return ApiResponse::sendResponse(200,'All Course Subscriptions For teacher',$result);
    }

    public function getOrderedBooks()//   شراء الطلبه للكتب
    {
        $teacher = Auth::guard('teacher')->user();

        $orderedBooks = $teacher->books()
                        ->whereHas('orderDetails', function ($query) {
                            $query->whereHas('orderBook', function ($subQuery) {
                                $subQuery->whereNotNull('user_id');
                            });
                        })
                        ->with(['orderDetails.orderBook.user', 'grade'])
                        ->get();

        $result = $orderedBooks->flatMap(function ($book) {
            return $book->orderDetails->map(function ($detail) use ($book) {
                return [
                    'book' => $book->name,
                    'grade' => $book->grade->name,
                    'user' => $detail->orderBook->user->name,
                    'quantity' => $detail->quantity,
                ];
            });
        });
        return ApiResponse::sendResponse(200,'All Book Subscriptions for teacher',$result);

    }

    public function getSubscriptionsCountForTeacher()  //  المواد المفعلة
    {
        $teacher = Auth::guard('teacher')->user();

        $courses = $teacher->courses()
        ->withCount('subscriptions')
        ->with('grade')
        ->get();

        $result = $courses->map(function ($course) {
            return [
                'course'              => $course->name,
                'grade'               => $course->grade->name,
                'subscriptions count' => $course->subscriptions_count,
            ];
        });

        return ApiResponse::sendResponse(200,'All Active Courses and count of subscriptions',$result);

    }

}
