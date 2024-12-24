<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Teacher\ChangePasswordRequest;
use App\Http\Requests\Auth\Teacher\RegisterRequest;
use App\Http\Resources\Teacher\DetailedTeacherResource;
use App\Models\Course\Course;
use App\Models\Teacher\Walet;
use App\Repositories\Auth\TeacherAuthRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Enums\Teacher\Type;
use App\Models\Teacher\Teacher;

class TeacherAuthController extends Controller
{
    protected $authRepository;

    public function __construct(TeacherAuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register(RegisterRequest $request)
    {
        DB::beginTransaction();
        $validated = $request->validated();

        $courseIds = Course::whereHas('translations', function ($query) use ($validated) {
            $query->where('name', 'like', '%' . $validated['course_name'] . '%');
        })->pluck('id');
        $gradeIds = $validated['grades'];

        unset($validated['grades']);
        unset($validated['course_name']);

        // i have grades and courses ids
        // dd($validated['grades']);
        // dd($courseIds);

        try {
            $validated['password'] = Hash::make($validated['password']);
            $validated['type'] = Type::ONLINE_COURSE->value;

            $image = $validated['image'] ?? null;
            unset($validated['image']);

            $teacher = Teacher::create($validated);

            $teacher->translateOrNew()->bio = $validated['bio_ar'] ?? null;
            $teacher->translateOrNew()->bio = $validated['bio_en'] ?? null;
            $teacher->translateOrNew()->description = $validated['description_ar'] ?? null;
            $teacher->translateOrNew()->description = $validated['description_en'] ?? null;

            if ($image) {
                $teacher->addMedia($image)
                    ->toMediaCollection('image');
            }

            $teacher->token = $teacher->createToken('Api Token')->plainTextToken;
            DB::commit();

            return ApiResponse::sendResponse(201, __('messages.user_register'),new DetailedTeacherResource($teacher));
        } catch (Exception $e) {
            DB::rollBack();

            return ApiResponse::sendResponse(500, __('messages.Registration_failed'), $e->getMessage());
        }
    }
//me
    // public function verifyEmail(VerifyEmailRequest $request)
    // {
    //     try {
    //         $teacher = $this->authRepository->verifyTeacher($request->validated()['token']);
    //         $teacher->token = $teacher->createToken('TeacherToken')->plainTextToken;
    //         return ApiResponse::sendResponse(200, __('messages.Email_verified_successfully'), new DetailedTeacherResource($teacher));
    //     } catch (Exception $e) {
    //         return ApiResponse::sendResponse(400, $e->getMessage());
    //     }
    // }

    // public function login(LoginRequest $request)
    // {
    //     // dd($request->email);
    //     try {
    //         $teacher = Teacher::where('email',$request->email)->first();

    //         if (!$teacher || !Hash::check($request->password, $teacher->password)) {
    //             return ApiResponse::sendResponse(401,  __('messages.Invalid_credentials'));
    //         }

    //         if (!$teacher->email_verified_at) {
    //             return ApiResponse::sendResponse(403, __('messages.User_not_verify'));
    //         }

    //         $teacher->token = $teacher->createToken('TeacherToken')->plainTextToken;
    //         return ApiResponse::sendResponse(200, __('messages.login_success'), new DetailedTeacherResource($teacher));
    //     } catch (Exception $e) {
    //         return ApiResponse::sendResponse(500, __('messages.login_fail'), $e->getMessage());
    //     }
    // }


    // public function forgotPassword(ForgotPasswordRequest $request)
    // {
    //     try {
    //         $email = $request->validated()['email'];
    //         $this->authRepository->findTeacherByEmail($email);
    //         $token = $this->authRepository->createTeacherResetToken($email);
    //         $this->authRepository->sendTeacherResetEmail($email, $token);

    //         return ApiResponse::sendResponse(200, __('message.Password_reset_link_sent'));
    //     } catch (Exception $e) {
    //         return ApiResponse::sendResponse(500, __('message.Failed_to_send_reset_link'), $e->getMessage());
    //     }
    // }

    // public function resetPassword(ResetPasswordRequest $request)
    // {
    //     try {
    //         $data = $request->validated();
    //         $this->authRepository->resetTeacherPassword(
    //             $data['email'],
    //             $data['password'],
    //             $data['password_confirmation'],
    //             $data['token']
    //         );

    //         return ApiResponse::sendResponse(200, __('message.Password_reset_successfully'));
    //     } catch (Exception $e) {
    //         return ApiResponse::sendResponse(400, __('message.Failed_to_reset_password'), $e->getMessage());
    //     }
    // }


    public function changePassword(ChangePasswordRequest $request)
    {
        try {
            $data = $request->validated();
            $teacher = Auth::guard('teacher')->user();
            $updatedTeacher = $this->authRepository->changeTeacherPassword(
                $teacher,
                $data['current_password'],
                $data['new_password']
            );
            return ApiResponse::sendResponse(200, __('message.Password_changed_successfully'), new DetailedTeacherResource($updatedTeacher));
        } catch (Exception $e) {
            return ApiResponse::sendResponse(400, __('message.Failed_to_change_password'), $e->getMessage());
        }
    }

    public function logout()
    {
        try {
            $teacher = Auth::guard('teacher')->user();
            $teacher->tokens()->delete();
            return ApiResponse::sendResponse(200, __('messages.log_out'));
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, __('messages.logout_fail'), $e->getMessage());
        }
    }
}
