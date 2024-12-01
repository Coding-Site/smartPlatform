<?php

namespace App\Models\Course;

use App\Models\Grade\Grade;
use App\Models\Scopes\TermScope;
use App\Models\Teacher\Teacher;
use App\Models\Term\Term;
use App\Models\Unit\Unit;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory, Translatable;
    protected $fillable = [
        'term_price',
        'monthly_price',
        'term_id',
        'teacher_id',
        'grade_id',
    ];

    public $translatedAttributes = ['name'];


    protected static function booted(): void
    {
        static::addGlobalScope(new TermScope(2));
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
    public function term()
    {
        return $this->belongsTo(Term::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function units()
    {
        return $this->hasMany(Unit::class);
    }

}
