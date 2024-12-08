<?php

namespace App\Models\Package;

use App\Models\Course\Course;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price','expiry_day','is_active','grade_id'];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_package');
    }
}
