<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Student\ForgotPasswordRequest;
use App\Http\Requests\Auth\Student\LoginRequest;
use App\Http\Requests\Auth\Student\ResetPasswordRequest;
use App\Http\Resources\Teacher\DetailedTeacherResource;
use App\Http\Resources\User\UserResource;
use App\Models\Admin\Admin;
use App\Models\Teacher\Teacher;
use App\Repositories\Auth\UserAuthRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthController extends Controller
{
    protected $authRepository;

    public function __construct(UserAuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }
    public function login(LoginRequest $request)
    {
        try {
            $teacher = Teacher::where('phone', $request->phone)->first();
            if ($teacher && Hash::check($request->password, $teacher->password)) {
                $teacher->token = $teacher->createToken('TeacherToken')->plainTextToken;
                return ApiResponse::sendResponse(200, __('messages.login_success'), new DetailedTeacherResource($teacher));
            }

            $admin = Admin::where('phone',$request->phone)->first();
            if ($admin && Hash::check($request->password, $admin->password)) {
                $admin->token = $admin->createToken('adminToken')->plainTextToken;
                return ApiResponse::sendResponse(200, __('messages.login_success'),$admin);
            }

            if (Auth::attempt($request->only('phone', 'password'))) {
                $user = Auth::user();
                $user->token = $user->createToken('UserToken')->plainTextToken;
                return ApiResponse::sendResponse(200, __('messages.login_success'), new UserResource($user));
            }

                return ApiResponse::sendResponse(401,  __('messages.Invalid_credentials'));
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, __('messages.login_fail') , $e->getMessage());
        }
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        try {
            $email = $request->validated()['email'];
            $this->authRepository->findUserByEmail($email);
            $token = $this->authRepository->createResetToken($email);
            $this->authRepository->sendResetEmail($email, $token);

            return ApiResponse::sendResponse(200, __('message.Password_reset_link_sent'));
        } catch (ModelNotFoundException $e) {
            return ApiResponse::sendResponse(404, __('message.User_not_found'));
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, __('message.Failed_to_send_reset_link'), $e->getMessage());
        }
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            $data = $request->validated();
            $this->authRepository->resetPassword(
                $data['email'],
                $data['password'],
                $data['password_confirmation'],
                $data['token']
            );

            return ApiResponse::sendResponse(200, __('message.Password_reset_successfully'));
        } catch (Exception $e) {
            return ApiResponse::sendResponse(400, __('message.Failed_to_reset_password') , $e->getMessage());
        }
    }
}
