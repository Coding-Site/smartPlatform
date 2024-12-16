<?php

namespace App\Models\Teacher;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['name','type','bio','description'];
}
