<?php

namespace App\Models\Lesson;

use App\Models\Unit\Unit;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory, Translatable;

    protected $fillable = ['url', 'unit_id'];

    public $translatedAttributes = ['title'];


    public function unit(){
        return $this->belongsTo(Unit::class);
    }

}
