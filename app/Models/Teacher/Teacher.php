<?php

namespace App\Models\Teacher;

use App\Models\Book\Book;
use App\Models\Comment\Comment;
use App\Models\Course\Course;
use App\Models\Stage\Stage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class Teacher extends Authenticatable implements MustVerifyEmail , HasMedia
{
    use HasFactory, HasApiTokens, Notifiable,HasRoles, InteractsWithMedia;
    protected $guard_name = 'teacher';
    protected $fillable = [
        'name', 'email', 'phone','course_id', 'stage_id','password' , 'bio','video_preview'
    ];

    public function books() : HasMany
    {
        return $this->hasMany(Book::class);
    }

    public function courses() : HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function stage() : BelongsTo
    {
        return $this->belongsTo(Stage::class);
    }

    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class);
    }


}
