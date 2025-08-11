<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseCategory;
use App\Models\CourseLevel;
use App\Models\CoursePriceRange;

class CourseCategoryController extends Controller
{
    public function index()
    {
        return view('admin.course.categories.index', [
            'categories' => CourseCategory::paginate(10),
            'levels'     => CourseLevel::paginate(10),
            'prices'     => CoursePriceRange::paginate(10),
        ]);
    }

    public function create()
    {
        return view('admin.course.categories.create');
    }
    public function createCategory()
    {
        return view('admin.course.categories.create_category');
    }

    public function storeCategory(Request $request)
    {
        $request->validate(['category' => 'required|string|max:255']);
        CourseCategory::create(['category' => $request->category]);

        return redirect()->route('admin.course-categories.index')
                         ->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $category = CourseCategory::findOrFail($id);
        return view('admin.course.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['category' => 'required|string|max:255']);
        CourseCategory::findOrFail($id)->update(['category' => $request->category]);

        return redirect()->route('admin.course-categories.index')
                         ->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        CourseCategory::findOrFail($id)->delete();
        return redirect()->route('admin.course-categories.index')
                         ->with('success', 'Kategori berhasil dihapus!');
    }

    public function createLevel()
    {
        return view('admin.course.categories.create_level');
    }

    public function storeLevel(Request $request)
    {
        $request->validate(['level' => 'required|string|max:255']);
        CourseLevel::create(['level' => $request->level]);

        return redirect()->route('admin.course-categories.index')
                         ->with('success', 'Level berhasil ditambahkan!');
    }

    public function editLevel($id)
    {
        $level = CourseLevel::findOrFail($id);
        return view('admin.course.categories.edit_level', compact('level'));
    }

    public function updateLevel(Request $request, $id)
    {
        $request->validate(['level' => 'required|string|max:255']);
        CourseLevel::findOrFail($id)->update(['level' => $request->level]);

        return redirect()->route('admin.course-categories.index')
                         ->with('success', 'Level berhasil diperbarui!');
    }

    public function destroyLevel($id)
    {
        CourseLevel::findOrFail($id)->delete();

        return redirect()->route('admin.course-categories.index')
                         ->with('success', 'Level berhasil dihapus!');
    }

    public function createPrice()
    {
        return view('admin.course.categories.create_price');
    }

    public function storePrice(Request $request)
    {
        $request->validate([
            'min_price' => 'required|numeric|min:0',
            'max_price' => 'required|numeric|gt:min_price',
        ]);

        CoursePriceRange::create([
            'min_price' => $request->min_price,
            'max_price' => $request->max_price,
        ]);

        return redirect()->route('admin.course-categories.index')
                         ->with('success', 'Rentang harga berhasil ditambahkan!');
    }

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

        CoursePriceRange::findOrFail($id)->update([
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
                         ->with('success', 'Rentang harga berhasil dihapus!');
    }
}
