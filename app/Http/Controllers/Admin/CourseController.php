<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseLevel;
use App\Models\CoursePriceRange;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::with(['category', 'level', 'priceRange'])
            ->withCount('students'); // supaya bisa filter & sort jumlah siswa

        // 🔍 Filter search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        // Filter kategori
        if ($request->filled('category')) {
            $query->where('course_category_id', $request->category);
        }

        // Filter level
        if ($request->filled('level')) {
            $query->where('course_level_id', $request->level);
        }

        // Filter rentang harga
        if ($request->filled('price_range')) {
            $range = explode('-', $request->price_range);
            if (count($range) == 2) {
                $query->whereBetween('price', [$range[0], $range[1]]);
            }
        }

        // Sort berdasarkan durasi
        if ($request->sort == 'duration_asc') {
            $query->withSum('lessons', 'duration')
                ->orderBy('lessons_sum_duration', 'asc');
        } elseif ($request->sort == 'duration_desc') {
            $query->withSum('lessons', 'duration')
                ->orderBy('lessons_sum_duration', 'desc');
        }

        // Sort jumlah siswa
        if ($request->sort == 'students_asc') {
            $query->orderBy('students_count', 'asc');
        } elseif ($request->sort == 'students_desc') {
            $query->orderBy('students_count', 'desc');
        }

        // Sort rating
        if ($request->sort == 'rating_asc') {
            $query->orderBy('rating', 'asc');
        } elseif ($request->sort == 'rating_desc') {
            $query->orderBy('rating', 'desc');
        }

        // Default order
        if (!$request->filled('sort')) {
            $query->latest();
        }

        $courses = $query->paginate(10)->withQueryString();

        // Data untuk filter
        $categories = CourseCategory::all();
        $levels = CourseLevel::all();

        return view('admin.course.list.index', compact('courses', 'categories', 'levels'));
    }

    public function create()
    {
        $categories = CourseCategory::all();
        $levels = CourseLevel::all();
        $prices = CoursePriceRange::all();

        return view('admin.course.list.create', compact('categories', 'levels', 'prices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_category_id' => 'required|exists:course_categories,id',
            'course_level_id' => 'required|exists:course_levels,id',
            'course_price_range_id' => 'nullable|exists:course_price_ranges,id',
            'name' => 'required|string|max:255|unique:courses,name',
            'price' => 'required|numeric|min:0',
            'duration' => 'nullable|string|max:255',
            'img' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('img')) {
            $data['img'] = $request->file('img')->store('courses', 'public');
        }

        Course::create($data);

        return redirect()->route('admin.course.index')->with('success', 'Kursus berhasil ditambahkan.');
    }

    public function edit(Course $course)
    {
        $categories = CourseCategory::all();
        $levels = CourseLevel::all();
        $prices = CoursePriceRange::all();

        return view('admin.course.list.edit', compact('course', 'categories', 'levels', 'prices'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'course_category_id' => 'required|exists:course_categories,id',
            'course_level_id' => 'required|exists:course_levels,id',
            'course_price_range_id' => 'nullable|exists:course_price_ranges,id',
            'name' => 'required|string|max:255|unique:courses,name,' . $course->id,
            'price' => 'required|numeric|min:0',
            'duration' => 'nullable|string|max:255',
            'img' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('img')) {
            // hapus file lama
            if ($course->img && Storage::disk('public')->exists($course->img)) {
                Storage::disk('public')->delete($course->img);
            }
            $data['img'] = $request->file('img')->store('courses', 'public');
        }

        $course->update($data);

        return redirect()->route('admin.course.index')->with('success', 'Kursus berhasil diperbarui.');
    }

    public function destroy(Course $course)
    {
        if ($course->img && Storage::disk('public')->exists($course->img)) {
            Storage::disk('public')->delete($course->img);
        }

        $course->delete();

        return redirect()->route('admin.course.index')->with('success', 'Kursus berhasil dihapus.');
    }
}