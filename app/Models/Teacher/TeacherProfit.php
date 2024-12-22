<?php

namespace App\Models\Teacher;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherProfit extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'book_id',
        'course_id',
        'profit',
        'quantity',
        'order_id'
    ];
}
