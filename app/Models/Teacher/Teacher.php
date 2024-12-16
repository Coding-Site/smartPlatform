<?php

namespace App\Models\Teacher;

use App\Enums\Teacher\Type;
use App\Models\Book\Book;
use App\Models\Comment\Comment;
use App\Models\Course\Course;
use App\Models\Review\Review;
use App\Models\Stage\Stage;
use Astrotomic\Translatable\Translatable;
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

class Teacher extends Authenticatable implements  HasMedia
{
    use HasFactory, HasApiTokens, Notifiable,HasRoles, InteractsWithMedia , Translatable;
    protected $guard_name = 'teacher';

    protected $fillable = [
        'email', 'phone','password' , 'years_of_experience', 'type', 'stage_id', 'grade_id'
    ];

    protected $with = ['translations'];
    public $translatedAttributes = ['name','bio','description'];

    protected $casts = [
        'type' => Type::class,
    ];


    public function scopeFilter($query, $type = null)
    {
        if ($type instanceof Type) {
            return $query->where('type', $type->value);
        }

        if (is_string($type)) {
            return $query->where('type', $type);
        }

        return $query;
    }

    public function scopeSearch($query, $searchTerm = null)
    {
        if ($searchTerm) {
            $query->whereHas('translations', function ($query) use ($searchTerm) {
                $query->where('name', 'LIKE', "%{$searchTerm}%");
            });
        }

        return $query;
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }

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

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

}
