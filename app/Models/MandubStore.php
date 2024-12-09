<?php

namespace App\Models;

use App\Models\Book\Book;
use App\Models\Mandub\Mandub;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MandubStore extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id', 'mandub_id', 'quantity'
    ];

    public function mandubs() : BelongsTo
    {
        return $this->belongsTo(Mandub::class);
    }

    public function books() : HasMany
    {
        return $this->hasMany(Book::class);
    }
}
