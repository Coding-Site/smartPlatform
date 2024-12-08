<?php

namespace App\Models\Subscription;

use App\Models\Course\Course;
use App\Models\Package\Package;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','course_id','subscription_type','start_date','end_date','is_active'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }


}
