<?php

namespace App\Models\Unit;

use App\Models\Course\Course;
use App\Models\Lesson\Lesson;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory,Translatable;

    protected $fillable = ['course_id'];
    public $translatedAttributes = ['title'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function lesson()
    {
        return $this->hasMany(Lesson::class);
    }

}
