<?php

namespace App\Models\Unit;

use App\Models\Course\Course;
use App\Models\Lesson\Lesson;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    use HasFactory,Translatable;

    protected $fillable = ['course_id'];
    protected $with = ['translations'];
    public $translatedAttributes = ['title'];

    public function course() : BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
    public function lessons() : HasMany
    {
        return $this->hasMany(Lesson::class);
    }

}
