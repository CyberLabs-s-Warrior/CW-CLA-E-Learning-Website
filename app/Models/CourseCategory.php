<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{
    protected $fillable = ['category'];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
