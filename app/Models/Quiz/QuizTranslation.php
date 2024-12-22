<?php

namespace App\Models\Quiz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['title'];
}
