<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseLevel;
use App\Models\CoursePriceRange;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['category', 'level', 'priceRange'])->latest()->paginate(10);
        return view('admin.course.list.index', compact('courses'));
    }


    public function create()
    {
        $categories = CourseCategory::all();
        $levels = CourseLevel::all();
        return view('admin.course.list.create', compact('categories', 'levels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'course_category_id' => 'required|exists:course_categories,id',
            'course_level_id' => 'required|exists:course_levels,id',
            'price' => 'required|numeric|min:0',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);


        $priceRange = CoursePriceRange::where('min_price', '<=', $request->price)
            ->where('max_price', '>=', $request->price)
            ->first();

        $data = $request->only([
            'name',
            'course_category_id',
            'course_level_id',
            'price',
        ]);
        $data['course_price_range_id'] = $priceRange ? $priceRange->id : null;

        if ($request->hasFile('img')) {
            $data['img'] = $request->file('img')->store('course', 'public');
        }

        Course::create($data);

        return redirect()->route('admin.course.index')->with('success', 'Course berhasil ditambahkan');
    }


    public function edit(Course $course)
    {
        $categories = CourseCategory::all();
        $levels = CourseLevel::all();
        return view('admin.course.list.edit', compact('course', 'categories', 'levels'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'course_category_id' => 'required|exists:course_categories,id',
            'course_level_id' => 'required|exists:course_levels,id',
            'price' => 'required|numeric|min:0',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $priceRange = CoursePriceRange::where('min_price', '<=', $request->price)
            ->where('max_price', '>=', $request->price)
            ->first();

        $data = $request->only([
            'name',
            'course_category_id',
            'course_level_id',
            'price',
        ]);
        $data['course_price_range_id'] = $priceRange ? $priceRange->id : null;

        if ($request->hasFile('img')) {
            if ($course->img && Storage::disk('public')->exists($course->img)) {
                Storage::disk('public')->delete($course->img);
            }
            $data['img'] = $request->file('img')->store('course', 'public');
        }

        $course->update($data);

        return redirect()->route('admin.course.index')->with('success', 'Course berhasil diperbarui');
    }

    public function destroy(Course $course)
    {
        if ($course->img && Storage::disk('public')->exists($course->img)) {
            Storage::disk('public')->delete($course->img);
        }

        $course->delete();

        return back()->with('success', 'Course berhasil dihapus');
    }
}
