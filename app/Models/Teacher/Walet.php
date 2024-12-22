<?php

namespace App\Models\Teacher;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Walet extends Model
{
    use HasFactory;

    protected $fillable = [
        'final_profit','teacher_id'
    ];


    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function transaction()
    {
        return $this->hasMany(WaletTransaction::class);
    }
}
