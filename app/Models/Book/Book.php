<?php

namespace App\Models\Book;

use App\Models\Grade\Grade;
use App\Models\Teacher\Teacher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'price', 'file', 'quantity', 'teacher_id', 'grade_id', 'course_id',
    ];


    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    public function teacher() : BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function grade() :  BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }
}
