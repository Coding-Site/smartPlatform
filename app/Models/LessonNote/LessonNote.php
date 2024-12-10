<?php

namespace App\Models\LessonNote;

use App\Models\Lesson\Lesson;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class LessonNote extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia;

    protected $fillable = [
        'lesson_id',
    ];

    public function lesson() : BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

}
