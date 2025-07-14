<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\About;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function index(Request $request)
    {
        $query = About::query();

        if ($request->filled('section')) {
            $query->where('section', $request->section);
        }

        // ✅ Gunakan paginate, bukan get()
        $contents = $query->orderBy('created_at', 'asc')->paginate(10);

        $sections = About::select('section')->distinct()->pluck('section');

        return view('admin.about.index', compact('contents', 'sections'));
    }


    public function create()
    {
        return view('admin.about.create');
    }

    public function store(Request $request)
    {
        // ✅ Validasi input
        $request->validate([
            'section' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // ✅ Ambil data yang relevan, buang null/kosong
        $data = array_filter($request->only(['section', 'title', 'description']), function ($value) {
            return $value !== null && $value !== '';
        });

        // ✅ Simpan gambar jika ada file
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('about_images', 'public');
        }

        // ✅ Simpan ke database
        About::create($data);

        // ✅ Redirect dengan flash message
        return redirect()->route('admin.about.index')->with('success', 'Konten berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $content = About::findOrFail($id);
        return view('admin.about.edit', compact('content'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'section' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $content = About::findOrFail($id);
        $data = $request->only(['section', 'title', 'description']);

        // Tidak mengupdate image pada edit
        $content->update($data);

        return redirect()->route('admin.about.index')->with('success', 'Konten berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $content = About::findOrFail($id);

        // Hapus file gambar dari storage (jika ada)
        if ($content->image && Storage::disk('public')->exists($content->image)) {
            Storage::disk('public')->delete($content->image);
        }

        $content->delete();

        return redirect()->route('admin.about.index')->with('success', 'Konten dan gambar berhasil dihapus.');
    }

}
