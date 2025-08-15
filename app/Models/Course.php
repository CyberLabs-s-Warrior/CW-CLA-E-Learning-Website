<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name',
        'price',
        'img',
        'course_category_id',
        'course_level_id',
        'course_price_range_id',
    ];

    public function category()
    {
        return $this->belongsTo(CourseCategory::class, 'course_category_id');
    }

    public function level()
    {
        return $this->belongsTo(CourseLevel::class, 'course_level_id');
    }

    public function priceRange()
    {
        return $this->belongsTo(CoursePriceRange::class, 'course_price_range_id');
    }

    public function detailCourses()
    {
        return $this->hasMany(DetailCourse::class);
    }

    public function lessons()
    {
        return $this->hasManyThrough(
            Lesson::class,
            DetailCourse::class,
            'course_id',          // Foreign key di table DetailCourse
            'detail_courses_id',  // Foreign key di table Lesson
            'id',                 // Local key Course
            'id'                  // Local key DetailCourse
        );
    }

}
