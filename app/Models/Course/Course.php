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
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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


    // protected static function booted(): void
    // {
    //     static::addGlobalScope(new TermScope(2));
    // }

    public function grade() : BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }
    public function term() : BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

    public function teacher() : BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function units() : HasMany
    {
        return $this->hasMany(Unit::class);
    }

}
