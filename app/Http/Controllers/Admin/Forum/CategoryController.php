<?php

namespace App\Http\Controllers\Admin\Forum;

use App\Http\Controllers\Controller;
use App\Models\ForumCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = ForumCategory::orderBy('sort_order')->paginate(15);
        return view('admin.forum.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.forum.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|min:3|max:120',
            'slug'        => 'nullable|string|max:140|unique:forum_categories,slug',
            'description' => 'nullable|string',
            'sort_order'  => 'nullable|integer|min:0',
            'is_private'  => 'nullable|boolean',
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        ForumCategory::create($data);

        return redirect()->route('admin.forum.categories.index')->with('success','Kategori dibuat.');
    }

    public function edit(ForumCategory $category)
    {
        return view('admin.forum.categories.edit', compact('category'));
    }

    public function update(Request $request, ForumCategory $category)
    {
        $data = $request->validate([
            'name'        => 'required|string|min:3|max:120',
            'slug'        => 'nullable|string|max:140|unique:forum_categories,slug,'.$category->id,
            'description' => 'nullable|string',
            'sort_order'  => 'nullable|integer|min:0',
            'is_private'  => 'nullable|boolean',
        ]);
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $category->update($data);

        return redirect()->route('admin.forum.categories.index')->with('success','Kategori diperbarui.');
    }

    public function destroy(ForumCategory $category)
    {
        $category->delete(); // soft delete
        return back()->with('success','Kategori diarsipkan.');
    }
}
