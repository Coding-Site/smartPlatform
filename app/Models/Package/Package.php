<?php

namespace App\Models\Package;

use App\Models\Book\Book;
use App\Models\Course\Course;
use App\Models\Grade\Grade;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Package extends Model
{
    use HasFactory , Translatable;

    protected $fillable = ['name', 'description', 'price','offer_price','expiry_day','is_active','grade_id'];

    protected $with = ['translations'];
    public $translatedAttributes = ['name','description'];

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
}
