<?php

namespace App\Models\Book;

use App\Models\Grade\Grade;
use App\Models\Stage\Stage;
use App\Models\Teacher\Teacher;
use App\Models\Term\Term;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class Book extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;

    protected $fillable = [
        'name', 'price', 'file_sample', 'quantity', 'teacher_id', 'grade_id','term_id'
    ];

    // protected static function booted(): void
    // {
    //     static::addGlobalScope(new TermScope(2));
    // }

    protected $casts = [
        'price'    => 'decimal:2',
        'quantity' => 'integer',
    ];

    public function teacher() : BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function grade() :  BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function term()
    {
        return $this->belongsTo(Term::class);
    }

    // public function stage()
    // {
    //     return $this->belongsTo(Stage::class);
    // }
}
