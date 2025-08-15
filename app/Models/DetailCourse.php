<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailCourse extends Model
{
    protected $table = 'detail_courses';

    protected $fillable = [
        'course_id',
        'description',
        'media',
        'modules',
    ];

    protected $casts = [
        'modules' => 'array',
        'media' => 'array',
    ];

    public function course()
    {
        // return $this->belongsTo(Course::class);
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'detail_courses_id');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'detail_courses_id');
    }
}
