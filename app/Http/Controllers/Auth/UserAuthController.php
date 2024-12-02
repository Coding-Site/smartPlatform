<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Student\ChangePasswordRequest;
use App\Http\Requests\Auth\Student\ForgotPasswordRequest;
use App\Http\Requests\Auth\Student\LoginRequest;
use App\Http\Requests\Auth\Student\RegisterRequest;
use App\Http\Requests\Auth\Student\ResetPasswordRequest;
use App\Http\Requests\Auth\Student\VerifyEmailRequest;
use App\Http\Resources\User\UserResource;
use App\Repositories\Auth\UserAuthRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    protected $authRepository;

    public function __construct(UserAuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register(RegisterRequest $request)
    {
        try {
            $user = $this->authRepository->create($request->validated());
            $token = $this->authRepository->generateActivationToken($user);
            $this->authRepository->sendActivationEmail($user, $token);

            return ApiResponse::sendResponse(201, __('messages.user_register'));
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, __('messages.Registration_failed') , $e->getMessage());
        }
    }

    public function verifyEmail(VerifyEmailRequest $request)
    {
        try {
            $user = $this->authRepository->verify($request->validated()['token']);
            $user->token = $user->createToken('studentToken')->plainTextToken;
            return ApiResponse::sendResponse(200, __('messages.Email_verified_successfully'), new UserResource($user));
        } catch (Exception $e) {
            return ApiResponse::sendResponse(400, $e->getMessage());
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            if (!Auth::attempt($request->only('email', 'password'))) {
                return ApiResponse::sendResponse(401, __('messages.Invalid_credentials'));
            }

            $user = Auth::user();
            if (!$user->email_verified_at) {
                return ApiResponse::sendResponse(403, __('messages.User_not_verify'));
            }

            $user->token = $user->createToken('UserToken')->plainTextToken;
            return ApiResponse::sendResponse(200, __('messages.login_success'), new UserResource($user));
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, __('messages.login_fail') , $e->getMessage());
        }
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        try {
            $email = $request->validated()['email'];
            $this->authRepository->findByEmail($email);
            $token = $this->authRepository->createResetToken($email);
            $this->authRepository->sendResetEmail($email, $token);

            return ApiResponse::sendResponse(200, __('message.Password_reset_link_sent'));
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, __('message.Failed_to_send_reset_link') , $e->getMessage());
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

    public function changePassword(ChangePasswordRequest $request)
    {
        try {
            $data = $request->validated();
            $user = Auth::user();

            $updatedUser = $this->authRepository->changePassword(
                $user,
                $data['current_password'],
                $data['new_password']
            );

            return ApiResponse::sendResponse(200, __('message.Password_changed_successfully'), new UserResource($updatedUser));
        } catch (Exception $e) {
            return ApiResponse::sendResponse(400, __('message.Failed_to_change_password') );
        }
    }

    public function logout()
    {
        try {
            $user = Auth::user();
            $user->tokens()->delete();
        return ApiResponse::sendResponse(200, __('messages.log_out'));
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, __('messages.logout_fail'), $e->getMessage());
        }
    }
}
