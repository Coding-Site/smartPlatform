<?php

namespace App\Models\Lesson;

use App\Models\Card\Card;
use App\Models\Comment\Comment;
use App\Models\LessonNote\LessonNote;
use App\Models\Quiz\Quiz;
use App\Models\Unit\Unit;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Lesson extends Model implements HasMedia
{
    use HasFactory, Translatable , InteractsWithMedia;

    protected $fillable = ['url', 'is_free', 'unit_id'];

    public $translatedAttributes = ['title'];


    public function unit() : BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function cards() : HasMany
    {
        return $this->hasMany(Card::class);
    }

    public function quiz() : HasOne
    {
        return $this->hasOne(Quiz::class);
    }

    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class);
    }

}
