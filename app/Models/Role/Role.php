<?php

namespace App\Models\Role;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory, Translatable;

    public $translatedAttributes = ['name'];

    protected $with = ['translations'];

    protected $fillable = ['guard_name'];
}
