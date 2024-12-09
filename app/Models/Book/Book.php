<?php

namespace App\Models\Book;

use App\Models\Grade\Grade;
use App\Models\MandubStore;
use App\Models\Teacher\Teacher;
use App\Models\Term\Term;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Book extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;

    protected $fillable = [
        'name',
        'paper_price',
        'paper_count',
        'covering_price',
        'price',
        'file_sample',
        'quantity',
        'teacher_id',
        'term_id',
        'grade_id',
    ];


    protected $casts = [
        'paper_price' => 'decimal:2',
        'covering_price' => 'decimal:2',
        'price' => 'decimal:2',
        'quantity' => 'integer',
        'paper_count' => 'integer',
    ];

    // protected static function booted(): void
    // {
    //     static::addGlobalScope(new TermScope(2));
    // }


    public function teacher() : BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function grade() :  BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function term() : BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

    public function orderBookDetails() : HasMany
    {
        return $this->hasMany(OrderBookDetail::class);
    }

    public function mandubStore() : BelongsTo
    {
        return $this->belongsTo(MandubStore::class);
    }

    // public function stage()
    // {
    //     return $this->belongsTo(Stage::class);
    // }
}
