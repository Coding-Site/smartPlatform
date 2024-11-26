<?php

namespace App\Repositories\Auth;

use App\Mail\PasswordResetMail;
use App\Mail\SendVerivicationCode;
use App\Models\User;
use App\Models\User\UserActivation;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthRepository
{
    public function create(array $data)
    {
        return User::create($data);
    }

    public function generateActivationToken($user)
    {
        $token = rand(100000, 999999);
        DB::table('user_activations')->insert([
            'user_id' => $user->id,
            'token' => $token,
            'created_at' => now(),
        ]);
        return $token;
    }

    public function findByEmail(string $email)
    {
        $user = User::where('email', $email)->first();
        if (!$user) {
            throw new Exception(__('messages.User_not_found'));
        }
        return $user;
    }

    public function createResetToken($email)
    {
        $token = rand(100000, 999999);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'token' => $token,
                'created_at' => now(),
            ]
        );

        return $token;
    }

    public function sendResetEmail($email, $token)
    {
        Mail::to($email)->send(new PasswordResetMail($token));
    }

    public function resetPassword($email, $password, $password_confirmation, $token)
    {
        $record = DB::table('password_reset_tokens')->where('email', $email)->first();

        if (!$record || $record->token != $token) {
            throw new Exception(__('messages.Invalid_reset_token_or_email'));
        }

        $user = $this->findByEmail($email);
        $user->forceFill(['password' => Hash::make($password)])->save();
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        return true;
    }

    public function sendActivationEmail($user, $token)
    {
        Mail::to($user->email)->queue(new SendVerivicationCode($token, $user->email, $user->name));
    }

    public function verify($token)
    {
        DB::beginTransaction();
        try {
            $verifyUser = UserActivation::where('token', $token)->first();

            if (!$verifyUser) {
                throw new Exception(__('messages.Verification_token_not_found'));
            }

            $user = $verifyUser->user;

            if ($user->email_verified_at !== null) {
                throw new Exception(__('messages.already_verified'));
            }

            $user->email_verified_at = now();
            $user->save();
            UserActivation::where('token', $token)->delete();

            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function changePassword($user, $currentPassword, $newPassword)
    {
        if (!Hash::check($currentPassword, $user->password)) {
            throw new Exception(__('messages.Current_password_is_incorrect'));
        }

        $user->password = Hash::make($newPassword);
        $user->save();

        return $user;
    }

}
