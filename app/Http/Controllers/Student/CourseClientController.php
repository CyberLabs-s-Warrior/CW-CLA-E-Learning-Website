<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;  

use App\Models\CourseCategory;
use App\Models\CoursePriceRange;
use App\Models\CourseLevel;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseClientController extends Controller
{
public function index(Request $request)
{
    $categories = CourseCategory::all();
    $priceRanges = CoursePriceRange::all();
    $levels = CourseLevel::all();

    $courses = Course::query();

    // Filter kategori (bisa multi-pilih)
    if ($request->filled('categories')) {
        $courses->whereIn('course_category_id', $request->categories);
    }

    // Filter harga
    if ($request->price === 'free') {
        $courses->where('price', 0);
    } elseif ($request->filled('price')) {
        $priceRange = CoursePriceRange::find($request->price);
        if ($priceRange) {
            $courses->whereBetween('price', [$priceRange->min_price, $priceRange->max_price]);
        }
    }

    // Filter level
    if ($request->filled('level')) {
        $courses->where('course_level_id', $request->level);
    }

    $courses = $courses->get();

    return view('student.course.index', compact('categories', 'priceRanges', 'levels', 'courses'));
}

}
