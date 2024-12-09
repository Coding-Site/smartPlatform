<?php

namespace App\Models\Grade;

use App\Models\Book\Book;
use App\Models\Course\Course;
use App\Models\Exam\Exam;
use App\Models\Exam\ExamBank;
use App\Models\Stage\Stage;
use App\Models\Term\Term;
use App\Models\User;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grade extends Model
{
    use HasFactory, Translatable ;

    public $translatedAttributes = ['name'];
    protected $fillable = [
        'stage_id',
        'term_id'
    ];



    public function stage() : BelongsTo
    {
        return $this->belongsTo(Stage::class);
    }


    public function exams() : HasMany
    {
        return $this->hasMany(Exam::class);
    }

    public function examBanks() : HasMany
    {
        return $this->hasMany(ExamBank::class);
    }

    public function term() : BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

    public function courses() : HasMany
    {
        return $this->hasMany(Course::class);
    }


    public function books() : HasMany
    {
        return $this->hasMany(Book::class);
    }


    public function users() : HasMany
    {
        return $this->hasMany(User::class);
    }

}
