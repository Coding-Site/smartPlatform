<?php

namespace App\Models\Book;

use App\Enums\Stage\Type;
use App\Models\Grade\Grade;
use App\Models\MandubStore;
use App\Models\Package\Package;
use App\Models\Stage\Stage;
use App\Models\Teacher\Teacher;
use App\Models\Term\Term;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Book extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia, Translatable;

    protected $fillable = [
        'type',
        'paper_price',
        'paper_count',
        'covering_price',
        'price',
        'quantity',
        'teacher_id',
        'term_id',
        'stage_id',
        'grade_id',
    ];

    protected $with = ['translations'];
    public $translatedAttributes = ['name'];


    protected $casts = [
        'paper_price' => 'decimal:2',
        'covering_price' => 'decimal:2',
        'price' => 'decimal:2',
        'quantity' => 'integer',
        'paper_count' => 'integer',
        'type' => Type::class,
    ];

    // protected static function booted(): void
    // {
    //     static::addGlobalScope(new TermScope(2));
    // }

    public function scopeFilter($query, $stageId = null, $gradeId = null, $type = null)
    {
        if ($stageId) {
            $query->where('stage_id', $stageId);
        }

        if ($gradeId) {
            $query->where('grade_id', $gradeId);
        }

        if ($type) {
            $query->where('type', $type);
        }

        return $query;
    }


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

    public function stage() : BelongsTo
    {
        return $this->belongsTo(Stage::class);
    }

    public function orderDetails()
{
    return $this->hasMany(OrderBookDetail::class);
}

    public function mandubStore() : BelongsTo
    {
        return $this->belongsTo(MandubStore::class);
    }

    public function orders()
    {
        return $this->hasManyThrough(OrderBookDetail::class, OrderBook::class, 'id', 'book_id', 'id', 'order_book_id');
    }

    public function packages()
    {
        return $this->belongsToMany(Package::class, 'book_package');
    }

    // public function stage()
    // {
    //     return $this->belongsTo(Stage::class);
    // }
}
