<?php

namespace App\Models\Question;

use App\Enums\Question\Type;
use App\Models\Choice\Choice;
use App\Models\Quiz\Quiz;
use App\Models\UserAnswer\UserAnswer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['quiz_id', 'question_text', 'type', 'correct_answer', 'cause', 'effect'];

    protected $casts = [
        'type' => Type::class,
    ];

    public function quiz() : BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function choices() : HasMany
    {
        return $this->hasMany(Choice::class);
    }

    public function userAnswers() : HasMany
    {
        return $this->hasMany(UserAnswer::class);
    }
}
