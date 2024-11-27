<?php

namespace App\Models\Term;

use App\Models\Course\Course;
use App\Models\Stage\Stage;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory, Translatable;

    public $translatedAttributes = ['name'];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }


}
