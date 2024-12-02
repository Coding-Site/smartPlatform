<?php

namespace App\Models\Term;

use App\Models\Course\Course;
use App\Models\Exam\Exam;
use App\Models\Grade\Grade;
use App\Models\Stage\Stage;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Term extends Model
{
    use HasFactory, Translatable;

    public $translatedAttributes = ['name'];

    public function courses() : HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function exams() : HasMany
    {
        return $this->hasMany(Exam::class);
    }

    public function grade() : hasMany
    {
        return $this->hasMany(Grade::class);
    }

}
