<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CoursePriceRange extends Model
{
    use HasFactory;

    protected $fillable = ['min_price', 'max_price'];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
    public function isFree(): bool
    {
        return $this->min_price == 0 && $this->max_price == 0;
    }
}
