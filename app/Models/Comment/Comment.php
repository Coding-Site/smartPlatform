<?php

namespace App\Models\Comment;

use App\Enums\Comment\Status;
use App\Models\Lesson\Lesson;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'lesson_id', 'content', 'parent_id', 'status'];

    protected $casts = [
        'status' => Status::class,
    ];


    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
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

}
