<?php

namespace App\Models\UserAnswer;

use App\Models\Choice\Choice;
use App\Models\Question\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'question_id', 'choice_id', 'answer', 'cause', 'effect', 'score'];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function question() : BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function choice() : BelongsTo
    {
        return $this->belongsTo(Choice::class);
    }
}
