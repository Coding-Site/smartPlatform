<?php

namespace App\Models\Package;

use App\Enums\Package\Type;
use App\Models\Book\Book;
use App\Models\Course\Course;
use App\Models\Grade\Grade;
use App\Models\Stage\Stage;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Package extends Model
{
    use HasFactory , Translatable;

    protected $fillable = ['type','price','offer_price','expiry_day','is_active','grade_id','stage_id'];

    protected $with = ['translations'];
    public $translatedAttributes = ['name','description'];

    protected $casts = [
        'price' => 'decimal:2',
        'offer_price' => 'decimal:2',
        'expiry_day' => 'date',
        'is_active' => 'boolean',
        'type' => Type::class
     ];

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

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_package');
    }

    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_package');
    }

    public function grade() : BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function stage() : BelongsTo
    {
        return $this->belongsTo(Stage::class);
    }
}
