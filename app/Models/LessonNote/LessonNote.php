<?php

namespace App\Models\LessonNote;

use App\Models\Lesson\Lesson;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LessonNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'file',
        'lesson_id',
    ];

    public function lesson() : BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

}
