<?php

namespace App\Models\Stage;

use App\Models\Term\Term;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory, Translatable;

    public $translatedAttributes = ['name'];
    protected $fillable = ['term_id'];

    public function terms()
    {
        return $this->belongsToMany(Term::class, 'term_stage');
    }
}
