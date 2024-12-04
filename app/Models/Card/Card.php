<?php

namespace App\Models\Card;

use App\Models\Lesson\Lesson;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'answer',
        'status',
        'lesson_id',
    ];

    public static function getCachedCardsForLesson($lessonId)
    {
        $cacheKey = 'lesson_' . $lessonId . '_cards';

        return Cache::remember($cacheKey, now()->addDays(30), function () use ($lessonId) {
            return self::where('lesson_id', $lessonId)->get();
        });
    }

    public static function clearCacheForLesson($lessonId)
    {
        $cacheKey = 'lesson_' . $lessonId . '_cards';
        Cache::forget($cacheKey);
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($card) {
            self::clearCacheForLesson($card->lesson_id);
        });

        static::updated(function ($card) {
            self::clearCacheForLesson($card->lesson_id);
        });

        static::deleted(function ($card) {
            self::clearCacheForLesson($card->lesson_id);
        });

    }

    public function lesson() : BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
}
