<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class DetailCourseClientController extends Controller
{
    public function index($slug)
    {
        $course = Course::with(['category','level','priceRange','lessons','students','reviews'])
            ->withCount(['students','lessons'])
            ->withAvg('reviews','rating')
            ->where('slug', $slug)
            ->firstOrFail();

        // Related courses (kategori sama, exclude course ini)
        $relatedCourses = Course::with(['category'])
            ->withCount(['students','lessons'])
            ->withAvg('reviews','rating')
            ->where('course_category_id', $course->course_category_id)
            ->where('id','!=',$course->id)
            ->take(6)
            ->get();

        return view('student.detail.index', compact('course','relatedCourses'));
    }
}
