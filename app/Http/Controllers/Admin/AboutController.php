<?php

namespace App\Http\Controllers\Admin;

use App\Models\About;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class AboutController extends Controller
{
public function index(Request $request)
{
    $query = About::query();

    // Filter berdasarkan section
    if ($request->filled('section')) {
        $query->where('section', $request->section);
    }

    // Filter berdasarkan judul search
    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    $contents = $query->orderBy('created_at', 'asc')->paginate(10);

    $sections = About::select('section')->distinct()->pluck('section');

    return view('admin.about.index', compact('contents', 'sections'));
}


    public function create()
    {
        $sections = About::select('section')->distinct()->pluck('section');
        return view('admin.about.create', compact('sections'));
    }

    public function store(Request $request)
    {
       $request->validate([
        'section' => 'required|string|max:255',
        'title' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'display_order' => 'nullable|integer',
        ]);

        $data = array_filter($request->only(['section','title','description','display_order']), fn($v) => $v !== null && $v !== '');


        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('about_images', 'public');
        }

        About::create($data);

        return redirect()->route('admin.about.index')->with('success', 'Konten berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $content = About::findOrFail($id);
        $sections = About::select('section')->distinct()->pluck('section');
        return view('admin.about.edit', compact('content', 'sections'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
        'section' => 'required|string|max:255',
        'title' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'display_order' => 'nullable|integer',
        ]);

        $content = About::findOrFail($id);
        $data = array_filter($request->only(['section','title','description','display_order']), fn($v) => $v !== null && $v !== '');


        if ($request->hasFile('image')) {
            if ($content->image && Storage::disk('public')->exists($content->image)) {
                Storage::disk('public')->delete($content->image);
            }

            $data['image'] = $request->file('image')->store('about_images', 'public');
        }

        $content->update($data);

        return redirect()->route('admin.about.index')->with('success', 'Konten berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $content = About::findOrFail($id);

        if ($content->image && Storage::disk('public')->exists($content->image)) {
            Storage::disk('public')->delete($content->image);
        }

        $content->delete();

        return redirect()->route('admin.about.index')->with('success', 'Konten dan gambar berhasil dihapus.');
    }
}
