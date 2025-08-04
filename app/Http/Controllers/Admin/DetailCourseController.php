<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DetailCourseController extends Controller
{
    public function index()
    {
        $courses = DetailCourse::latest()->get();
        return view('admin.detail_courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.detail_courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,mov,avi|max:10240',
            'modules' => 'required|array',
        ]);

        $mediaPath = null;
        if ($request->hasFile('media')) {
            $mediaPath = $request->file('media')->store('detail_courses', 'public');
        }

        DetailCourse::create([
            'title' => $request->title,
            'description' => $request->description,
            'media' => $mediaPath,
            'modules' => $request->modules,
        ]);

        return redirect()->route('admin.detail_courses.index')->with('success', 'Kursus berhasil ditambahkan.');
    }

    public function show(DetailCourse $detailCourse)
    {
        return view('admin.detail_courses.show', compact('detailCourse'));
    }

    public function edit(DetailCourse $detailCourse)
    {
        return view('admin.detail_courses.edit', compact('detailCourse'));
    }

    public function update(Request $request, DetailCourse $detailCourse)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,mov,avi|max:10240',
            'modules' => 'required|array',
        ]);

        $mediaPath = $detailCourse->media;

        if ($request->hasFile('media')) {
            if ($mediaPath && Storage::disk('public')->exists($mediaPath)) {
                Storage::disk('public')->delete($mediaPath);
            }

            $mediaPath = $request->file('media')->store('detail_courses', 'public');
        }

        $detailCourse->update([
            'title' => $request->title,
            'description' => $request->description,
            'media' => $mediaPath,
            'modules' => $request->modules,
        ]);

        return redirect()->route('admin.detail_courses.index')->with('success', 'Kursus berhasil diperbarui.');
    }

    public function destroy(DetailCourse $detailCourse)
    {
        if ($detailCourse->media && Storage::disk('public')->exists($detailCourse->media)) {
            Storage::disk('public')->delete($detailCourse->media);
        }

        $detailCourse->delete();
        return redirect()->route('admin.detail_courses.index')->with('success', 'Kursus berhasil dihapus.');
    }
}
