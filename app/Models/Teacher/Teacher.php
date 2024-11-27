<?php

namespace App\Models\Teacher;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Teacher extends Model
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $fillable = [
        'name', 'email', 'phone','courses', 'stage','password'
    ];
}
