<?php

namespace App\Models\Grade;

use App\Models\Course\Course;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory, Translatable ;

    public $translatedAttributes = ['name'];
    protected $fillable = ['stage_id'];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_grade');
    }

}
