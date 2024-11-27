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


    public $translatedAttributes = ['name'];
    protected $fillable = ['term_price', 'teacher_id','monthly_price'];


    protected static function booted()
    {
        if (session('term_id')) {
            static::addGlobalScope(new TermScope(session('term_id')));
        }
    }
    public function grades()
    {
        return $this->belongsTo(Grade::class);
    }
    public function terms()
    {
        return $this->belongsTo(Term::class);
    }

    public function teachers()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function units()
    {
        return $this->hasMany(Unit::class);
    }

}
