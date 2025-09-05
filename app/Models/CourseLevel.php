<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseLevel extends Model
{
    use HasFactory;

    protected $fillable = ['level'];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
