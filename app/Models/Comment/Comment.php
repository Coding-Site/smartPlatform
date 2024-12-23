<?php

namespace App\Models\Comment;

use App\Enums\Comment\Status;
use App\Models\Lesson\Lesson;
use App\Models\Like\Like;
use App\Models\Teacher\Teacher;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Comment extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'teacher_id',
        'lesson_id',
        'content',
        'parent_id',
        'status',
    ];
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function teacher() : BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function lesson() : BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function replies() : HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function parent() : BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', Status::APPROVED->value);
    }

    public function scopePending($query)
    {
        return $query->where('status', Status::PENDING->value);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', Status::REJECTED->value);
    }

    public function isApproved(): bool
    {
        return $this->status === Status::APPROVED;
    }

    public function isPending(): bool
    {
        return $this->status === Status::PENDING;
    }

    public function isRejected(): bool
    {
        return $this->status === Status::REJECTED;
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }



}
