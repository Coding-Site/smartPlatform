<?php

namespace App\Models\Book;

use App\Models\City\City;
use App\Models\Mandub\Mandub;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderBookDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'price','book_id','quantity'
    ];


    
}
