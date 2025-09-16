<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseCategory;
use App\Models\CourseLevel;
use App\Models\CoursePriceRange;

class CourseCategoryController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->tab ?? 'kategori'; // default tab kategori

        // Default query
        $categories = CourseCategory::latest()->paginate(10, ['*'], 'categories_page');
        $levels = CourseLevel::latest()->paginate(10, ['*'], 'levels_page');
        $prices = CoursePriceRange::latest()->paginate(10, ['*'], 'prices_page');

        // Apply search sesuai tab aktif
        if ($tab === 'kategori' && $request->search) {
            $categories = CourseCategory::where('category', 'like', "%{$request->search}%")
                ->latest()
                ->paginate(10, ['*'], 'categories_page');
        }

        if ($tab === 'level' && $request->search) {
            $levels = CourseLevel::where('level', 'like', "%{$request->search}%")
                ->latest()
                ->paginate(10, ['*'], 'levels_page');
        }

        if ($tab === 'harga' && $request->search) {
            $prices = CoursePriceRange::where(function ($q) use ($request) {
                $q->where('min_price', 'like', "%{$request->search}%")
                    ->orWhere('max_price', 'like', "%{$request->search}%");
            })
                ->latest()
                ->paginate(10, ['*'], 'prices_page');
        }

        return view('admin.course.categories.index', compact('categories', 'levels', 'prices'));
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
        $request->validate([
            'category' => 'required|string|max:255'
        ]);

        CourseCategory::create($request->only('category'));

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
        $request->validate([
            'category' => 'required|string|max:255'
        ]);

        $category = CourseCategory::findOrFail($id);
        $category->update($request->only('category'));

        return redirect()->route('admin.course-categories.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $category = CourseCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.course-categories.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }

    public function createLevel()
    {
        return view('admin.course.categories.create_level');
    }

    public function storeLevel(Request $request)
    {
        $request->validate([
            'level' => 'required|string|max:255'
        ]);

        CourseLevel::create($request->only('level'));

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
        $request->validate([
            'level' => 'required|string|max:255'
        ]);

        $level = CourseLevel::findOrFail($id);
        $level->update($request->only('level'));

        return redirect()->route('admin.course-categories.index')
            ->with('success', 'Level berhasil diperbarui!');
    }

    public function destroyLevel($id)
    {
        $level = CourseLevel::findOrFail($id);
        $level->delete();

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

        CoursePriceRange::create($request->only(['min_price', 'max_price']));

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

        $price = CoursePriceRange::findOrFail($id);
        $price->update($request->only(['min_price', 'max_price']));

        return redirect()->route('admin.course-categories.index')
            ->with('success', 'Rentang harga berhasil diperbarui!');
    }

    public function destroyPrice($id)
    {
        $price = CoursePriceRange::findOrFail($id);
        $price->delete();

        return redirect()->route('admin.course-categories.index')
            ->with('success', 'Rentang harga berhasil dihapus!');
    }
}
