<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseLevel;
use App\Models\CoursePriceRange;
use Illuminate\Http\Request;

class KatalogClientController extends Controller
{
    public function index(Request $request)
    {
        // dropdown sumber DB
        $categories  = CourseCategory::orderBy('category')->get();
        $levels      = CourseLevel::orderBy('level')->get();
        $priceRanges = CoursePriceRange::orderBy('min_price')->get();

        // Query dasar: hanya kursus "publish/available"
        $courses = Course::query()
            ->with(['category','level','priceRange'])
            ->withCount(['students','lessons'])
            ->withAvg('reviews', 'rating');

        // kalau kamu punya kolom is_published / is_active di courses:
        // $courses->where('is_published', 1);

        // === Filter Category (id) ===
        if ($request->filled('category')) {
            $courses->where('course_category_id', $request->input('category'));
        }

        // === Filter Price ===
        // free → price == 0
        // numeric id → ambil range lalu whereBetween
        if ($request->price === 'free') {
            $courses->where('price', 0);
        } elseif ($request->filled('price') && ctype_digit((string)$request->price)) {
            $range = $priceRanges->firstWhere('id', (int)$request->price);
            if ($range) {
                $courses->whereBetween('price', [$range->min_price, $range->max_price]);
            }
        }

        // === Filter Level (id) ===
        if ($request->filled('level')) {
            $courses->where('course_level_id', $request->input('level'));
        }

        // Urutan & pagination
        $courses = $courses
            ->orderByDesc('created_at')
            ->paginate(9);

        return view('guest.katalog.index', compact('categories','levels','priceRanges','courses'));
    }
}
