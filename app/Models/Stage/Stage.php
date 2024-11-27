<?php

namespace App\Models\Stage;

use App\Models\Course\Course;
use App\Models\Grade\Grade;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory, Translatable;

    public $translatedAttributes = ['name'];
    protected $fillable = ['term_id'];


    public function grades(){
        return $this->hasMany(Grade::class);
    }

    public function Courses(){
        return $this->hasMany(Course::class);
    }
}
