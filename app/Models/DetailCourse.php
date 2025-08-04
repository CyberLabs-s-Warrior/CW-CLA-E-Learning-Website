<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailCourse extends Model
{
    protected $table = 'detail_courses'; // karena tidak pakai default plural

    protected $fillable = [
        'title',
        'description',
        'media',
        'modules',
    ];

    protected $casts = [
        'modules' => 'array',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class, 'detail_courses_id');
    }
    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'detail_courses_id');
    }
}