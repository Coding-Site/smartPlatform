<?php

namespace App\Models\Exam;

use App\Models\Course\Course;
use App\Models\Grade\Grade;
use App\Models\Term\Term;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ExamBank extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia;

    protected $fillable = [
        'name', 'grade_id', 'term_id', 'course_id',
        'unresolved', 'solved', 'book_solution'
    ];

    public function grade() : BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function term() : BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

    public function course() : BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
