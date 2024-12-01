<?php

namespace App\Models\Exam;

use App\Models\Grade\Grade;
use App\Models\Term\Term;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'files',
        'grade_id',
        'term_id'
    ];

    protected $casts = [
        'files' => 'array',
    ];

    public function grade() : BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function term() : BelongsTo
    {
        return $this->belongsTo(Term::class);
    }
}
