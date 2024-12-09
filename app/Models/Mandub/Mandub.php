<?php

namespace App\Models\Mandub;

use App\Models\Book\OrderBookDetail;
use App\Models\City\City;
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



}
