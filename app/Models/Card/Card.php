<?php

namespace App\Models\Card;

use App\Models\Lesson\Lesson;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'answer',
        'status',
        'lesson_id',
    ];

    public function lesson() : BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
}
