<?php

namespace App\Models\Like;

use App\Models\Comment\Comment;
use App\Models\Teacher\Teacher;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = ['likable_id', 'likable_type', 'comment_id'];

    public function likable()
    {
        return $this->morphTo();
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }


}
