<?php

namespace App\Models\Course;

use App\Models\Grade\Grade;
use App\Models\Scopes\TermScope;
use App\Models\Stage\Stage;
use App\Models\Subscription\Subscription;
use App\Models\Teacher\Teacher;
use App\Models\Term\Term;
use App\Models\Unit\Unit;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Course extends Model implements HasMedia
{
    use HasFactory, Translatable, InteractsWithMedia;
    public $translatedAttributes = ['name'];
    protected $fillable = [
        'term_price',
        'monthly_price',
        'term_end_date',
        'term_id',
        'teacher_id',
        'stage_id',
        'grade_id',
    ];



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

    public function stage() : BelongsTo
    {
        return $this->belongsTo(Stage::class);
    }

    public function scopeFilter($query, $stageId = null, $gradeId = null)
    {
        if ($stageId) {
            $query->where('stage_id', $stageId);
        }
        if ($gradeId) {
            $query->where('grade_id', $gradeId);
        }
        return $query;
    }

    public function subscribers()
    {
        return $this->hasMany(Subscription::class);
    }

}
