<?php

namespace App\Models\Book;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['name'];
}
