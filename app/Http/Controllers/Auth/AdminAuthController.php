<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Teacher\LoginRequest;
use App\Models\Admin\Admin;
use Exception;

class AdminAuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {
            $admin = Admin::where('email',$request->email)->first();
            $admin->token = $admin->createToken('TeacherToken')->plainTextToken;
            return ApiResponse::sendResponse(200, __('messages.login_success'),$admin);
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, __('messages.login_fail'), $e->getMessage());
        }
    }
}
