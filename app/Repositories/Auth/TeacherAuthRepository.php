<?php


namespace App\Repositories\Auth;

use App\Mail\PasswordResetMail;
use App\Mail\SendVerivicationCode;
use App\Models\Teacher\Teacher;
use App\Models\Teacher\TeacherActivation;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class TeacherAuthRepository
{
    public function createTeacher(array $data)
    {
        $data['password'] = Hash::make($data['password']);

        $image = $data['image'] ?? null;
        unset($data['image']);

        $teacher = Teacher::create($data);

        if ($image) {
            $teacher->addMedia($image)
                ->toMediaCollection('image');
        }

        return $teacher;
    }

    public function generateTeacherActivationToken($teacher)
    {
        $token = rand(100000, 999999);
        DB::table('teacher_activations')->insert([
            'teacher_id' => $teacher->id,
            'token'      => $token,
            'created_at' => now(),
        ]);
        return $token;
    }

    public function findTeacherByEmail(string $email)
    {
        $teacher = Teacher::where('email', $email)->first();
        if (!$teacher) {
            throw new Exception(__('messages.Teacher_not_found'));
        }
        return $teacher;
    }

    public function createTeacherResetToken($email)
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

    public function sendTeacherResetEmail($email, $token)
    {
        Mail::to($email)->send(new PasswordResetMail($token));
    }

    public function resetTeacherPassword($email, $password, $password_confirmation, $token)
    {
        $record = DB::table('password_reset_tokens')->where('email', $email)->first();

        if (!$record || $record->token != $token) {
            throw new Exception(__('messages.Invalid_reset_token_or_email'));
        }

        $teacher = $this->findTeacherByEmail($email);
        $teacher->forceFill(['password' => Hash::make($password)])->save();
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        return true;
    }

    public function sendTeacherActivationEmail($teacher, $token)
    {
        Mail::to($teacher->email)->queue(new SendVerivicationCode($token, $teacher->email, $teacher->name));
    }

    public function verifyTeacher($token)
    {
        DB::beginTransaction();
        try {
            $verifyTeacher = TeacherActivation::where('token', $token)->first();
            if (!$verifyTeacher) {
                throw new Exception(__('messages.Verification_token_not_found'));
            }

            $teacher = $verifyTeacher->teacher;

            if ($teacher->email_verified_at !== null) {
                throw new Exception(__('messages.already_verified'));
            }

            $teacher->email_verified_at = now();
            $teacher->save();
            TeacherActivation::where('token', $token)->delete();

            DB::commit();
            return $teacher;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function changeTeacherPassword($teacher, $currentPassword, $newPassword)
    {

        if (!Hash::check($currentPassword, $teacher->password)) {

            throw new Exception(__('messages.Current_password_is_incorrect'));
        }

        $teacher->password = Hash::make($newPassword);
        $teacher->save();

        return $teacher;
    }
}
