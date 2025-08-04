<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'detail_courses_id',
        'module_name',
        'title',
        'content',
        'media',
    ];

    public function course()
    {
        return $this->belongsTo(DetailCourse::class, 'detail_courses_id');
    }
}
