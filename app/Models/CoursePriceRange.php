<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoursePriceRange extends Model
{
    protected $fillable = ['min_price', 'max_price'];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
