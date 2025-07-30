<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseCategory;
use App\Models\CourseLevel;
use App\Models\CoursePriceRange;

class CourseCategoryController extends Controller
{
    // INDEX
    public function index()
    {
        return view('admin.course.categories.index', [
            'categories' => CourseCategory::all(),
            'levels' => CourseLevel::all(),
            'prices' => CoursePriceRange::all(),
        ]);
    }

    // CREATE FORM
    public function create()
    {
        return view('admin.course.categories.create');
    }

    // STORE: Category / Level / Price
    public function store(Request $request)
    {
        if ($request->has('category')) {
            $request->validate([
                'category' => 'required|string|max:255'
            ]);

            CourseCategory::create(['category' => $request->category]);

            return redirect()->route('admin.course-categories.index')
                ->with('success', 'Kategori berhasil ditambahkan!');
        }

        if ($request->has('level')) {
            $request->validate([
                'level' => 'required|string|max:255'
            ]);

            CourseLevel::create(['level' => $request->level]);

            return redirect()->route('admin.course-categories.index')
                ->with('success', 'Level berhasil ditambahkan!');
        }

        if ($request->has('min_price') && $request->has('max_price')) {
            $request->validate([
                'min_price' => 'required|numeric|min:0',
                'max_price' => 'required|numeric|gt:min_price'
            ]);

            CoursePriceRange::create([
                'min_price' => $request->min_price,
                'max_price' => $request->max_price,
            ]);

            return redirect()->route('admin.course-categories.index')
                ->with('success', 'Rentang harga berhasil ditambahkan!');
        }

        return redirect()->route('admin.course-categories.index')
            ->with('error', 'Data tidak valid atau tidak lengkap.');
    }

    // ======================
    // KATEGORI METHODS
    // ======================

    public function edit($id)
    {
        $category = CourseCategory::findOrFail($id);
        return view('admin.course.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category' => 'required|string|max:255',
        ]);

        $category = CourseCategory::findOrFail($id);
        $category->update(['category' => $request->category]);

        return redirect()->route('admin.course-categories.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        CourseCategory::findOrFail($id)->delete();

        return redirect()->route('admin.course-categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }

    // ======================
    // LEVEL METHODS
    // ======================

    public function editLevel($id)
    {
        $level = CourseLevel::findOrFail($id);
        return view('admin.course.categories.edit_level', compact('level'));
    }

    public function updateLevel(Request $request, $id)
    {
        $request->validate([
            'level' => 'required|string|max:255',
        ]);

        $level = CourseLevel::findOrFail($id);
        $level->update(['level' => $request->level]);

        return redirect()->route('admin.course-categories.index')
            ->with('success', 'Level berhasil diperbarui!');
    }

    public function destroyLevel($id)
    {
        CourseLevel::findOrFail($id)->delete();

        return redirect()->route('admin.course-categories.index')
            ->with('success', 'Level berhasil dihapus.');
    }

    // ======================
    // PRICE METHODS
    // ======================

    public function editPrice($id)
    {
        $price = CoursePriceRange::findOrFail($id);
        return view('admin.course.categories.edit_price', compact('price'));
    }

    public function updatePrice(Request $request, $id)
    {
        $request->validate([
            'min_price' => 'required|numeric|min:0',
            'max_price' => 'required|numeric|gt:min_price',
        ]);

        $price = CoursePriceRange::findOrFail($id);
        $price->update([
            'min_price' => $request->min_price,
            'max_price' => $request->max_price,
        ]);

        return redirect()->route('admin.course-categories.index')
            ->with('success', 'Rentang harga berhasil diperbarui!');
    }

    public function destroyPrice($id)
    {
        CoursePriceRange::findOrFail($id)->delete();

        return redirect()->route('admin.course-categories.index')
            ->with('success', 'Rentang harga berhasil dihapus.');
    }
}
