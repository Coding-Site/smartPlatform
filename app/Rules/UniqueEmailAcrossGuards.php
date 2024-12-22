<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueEmailAcrossGuards implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $existsInUsers = DB::table('users')->where('email', $value)->exists();
        $existsInTeachers = DB::table('teachers')->where('email', $value)->exists();
        $existsInAdmins = DB::table('admins')->where('email', $value)->exists();

        if ($existsInUsers || $existsInTeachers || $existsInAdmins) {
            $fail(__('messages.emailTaken'));
        }
    }
}
