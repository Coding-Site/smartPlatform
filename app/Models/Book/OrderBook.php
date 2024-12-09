<?php

namespace App\Models\Book;

use App\Enums\OrderBook\Status;
use App\Models\City\City;
use App\Models\Mandub\Mandub;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'address',
        'city_id',
        'user_id',
        'mandub_id',
        'status',
        'total_price',
    ];

    protected $casts = [
        'status' => Status::class,
    ];
    public function city() : BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function mandub() : BelongsTo
    {
        return $this->belongsTo(Mandub::class);
    }

    public function orderBookDetails() : HasMany
    {
        return $this->hasMany(OrderBookDetail::class);
    }
}
