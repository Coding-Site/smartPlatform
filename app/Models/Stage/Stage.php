<?php

namespace App\Models\Stage;

use App\Models\Course\Course;
use App\Models\Grade\Grade;
use App\Models\Teacher\Teacher;
use App\Models\User;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stage extends Model
{
    use HasFactory, Translatable;

    public $translatedAttributes = ['name'];
    protected $fillable = ['term_id'];


    public function grades() : HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function users() : HasMany
    {
        return $this->hasMany(User::class);
    }


    public function teachers() : HasMany
    {
        return $this->hasMany(Teacher::class);
    }


}