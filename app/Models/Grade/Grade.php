<?php

namespace App\Models\Grade;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory, Translatable ;

    // protected $table = 'grades';
    public $translatedAttributes = ['name'];
    protected $fillable = ['stage_id'];
}
