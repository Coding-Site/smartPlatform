<?php

namespace App\Models\Stage;

use App\Models\Book\Book;
use App\Models\Course\Course;
use App\Models\Grade\Grade;
use App\Models\Package\Package;
use App\Models\Teacher\Teacher;
use App\Models\User;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stage extends Model
{
    use HasFactory, Translatable;

    public $translatedAttributes = ['name'];
    protected $fillable = ['term_id'];


    public function grades() : HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function users() : HasMany
    {
        return $this->hasMany(User::class);
    }


    public function teachers() : HasMany
    {
        return $this->hasMany(Teacher::class);
    }

    public function courses()
    {
        return $this->hasManyThrough(Course::class, Grade::class,'stage_id','grade_id');
    }

    public function books()  : HasMany
    {
        return $this->hasMany(Book::class);
    }

    public function packages() : HasMany
    {
        return $this->hasMany(Package::class);
    }

}
