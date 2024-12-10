<?php

namespace App\Models\City;

use App\Models\Book\OrderBook;
use App\Models\Book\OrderBookDetail;
use App\Models\Mandub\Mandub;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'deliver_price'
    ];


    public function mandubs() : BelongsToMany
    {
        return $this->belongsToMany(Mandub::class, 'mandub_cities');
    }

    public function orderBooks() : HasMany
    {
        return $this->hasMany(OrderBook::class);
    }

}
