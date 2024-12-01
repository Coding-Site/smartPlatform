<?php

namespace App\Models\Choice;

use App\Models\Question\Question;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Choice extends Model
{
    use HasFactory;

    protected $fillable = [
        'choice_text',
        'question_id',
        'is_correct',
    ];

    public function question() : BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
