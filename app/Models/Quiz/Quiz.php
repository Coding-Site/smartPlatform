<?php

namespace App\Models\Quiz;

use App\Models\Lesson\Lesson;
use App\Models\Question\Question;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    use HasFactory , Translatable;

    protected $fillable = [
        'lesson_id',
    ];

    protected $with = ['translations'];
    public $translatedAttributes = ['title'];

    public function lesson() : BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function questions() : HasMany
    {
        return $this->hasMany(Question::class);
    }
}
