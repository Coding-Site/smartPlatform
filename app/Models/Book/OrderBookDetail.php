<?php

namespace App\Models\Book;

use App\Models\City\City;
use App\Models\Mandub\Mandub;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderBookDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_book_id','book_id','quantity'
    ];

    public function orderBook() : BelongsTo
    {
        return $this->belongsTo(OrderBook::class);
    }

    public function book() : BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

}
