<?php

namespace App\Models\Mandub;

use App\Models\Book\OrderBook;
use App\Models\Book\OrderBookDetail;
use App\Models\City\City;
use App\Models\MandubStore;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;
class Mandub extends  Authenticatable  implements HasMedia
{
    use HasFactory, HasApiTokens, HasRoles,InteractsWithMedia;


    protected $fillable = [
        'name', 'email', 'phone','password','image'
    ];

    public function city() : BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function cities() : BelongsToMany
    {
        return $this->belongsToMany(City::class, 'mandub_cities');
    }

    public function orderBooks() : HasMany
    {
        return $this->hasMany(OrderBook::class);
    }

    public function mandoubStore() : HasOne
    {
        return $this->hasOne(MandubStore::class);
    }

}
