<?php

namespace App\Models\Cart;

use App\Models\Book\Book;
use App\Models\Course\Course;
use App\Models\Package\Package;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id','quantity','price','book_id'
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

}
