<?php

namespace App\Models\Course;

use App\Models\Grade\Grade;
use App\Models\Unit\Unit;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory, Translatable;


    public $translatedAttributes = ['name'];
    protected $fillable = ['term_price', 'teacher_id','monthly_price'];


    public function grades()
    {
        return $this->belongsToMany(Grade::class, 'course_grade');
    }

    public function units()
    {
        return $this->hasMany(Unit::class);
    }

}
