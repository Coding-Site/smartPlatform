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

class Exam extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia;

    protected $fillable = [
        'course_id',
    ];

    public function course() : BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
