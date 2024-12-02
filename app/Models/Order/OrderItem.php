<?php

namespace App\Models\Order;

use App\Models\Book\Book;
use App\Models\Course\Course;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id','course_id','book_id','quantity','price'
    ];

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
