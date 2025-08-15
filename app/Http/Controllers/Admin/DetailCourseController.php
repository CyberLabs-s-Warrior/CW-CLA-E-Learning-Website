<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailCourse;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DetailCourseController extends Controller
{
    public function index()
    {
        $courses = DetailCourse::with('course')->latest()->paginate(10);
        return view('admin.detail_courses.index', compact('courses'));
    }

    public function create()
    {
        $courseList = Course::pluck('name', 'id');
        return view('admin.detail_courses.create', compact('courseList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'description' => 'nullable|string',
            'media.*' => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,mov,avi|max:10240',
            'modules' => 'required|array',
        ]);

        $mediaPaths = [];
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $mediaPaths[] = $file->store('detail_courses', 'public');
            }
        }

        DetailCourse::create([
            'course_id' => $request->course_id,
            'description' => $request->description,
            'media' => $mediaPaths,
            'modules' => $request->modules,
        ]);

        return redirect()->route('admin.detail_courses.index')->with('success', 'Detail kursus berhasil ditambahkan.');
    }

    public function show(DetailCourse $detailCourse)
    {
        return view('admin.detail_courses.show', compact('detailCourse'));
    }

    public function edit(DetailCourse $detailCourse)
    {
        $courseList = Course::pluck('name', 'id');
        return view('admin.detail_courses.edit', compact('detailCourse', 'courseList'));
    }

    public function update(Request $request, DetailCourse $detailCourse)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'description' => 'nullable|string',
            'media.*' => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,mov,avi|max:10240',
            'modules' => 'required|array',
            'remove_media' => 'nullable|array',
        ]);

        $mediaPaths = $detailCourse->media ?? [];


        if ($request->filled('remove_media')) {
            foreach ($request->remove_media as $index) {
                if (isset($mediaPaths[$index]) && Storage::disk('public')->exists($mediaPaths[$index])) {
                    Storage::disk('public')->delete($mediaPaths[$index]);
                    unset($mediaPaths[$index]);
                }
            }

            $mediaPaths = array_values($mediaPaths);
        }

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $mediaPaths[] = $file->store('detail_courses', 'public');
            }
        }

        $detailCourse->update([
            'course_id' => $request->course_id,
            'description' => $request->description,
            'media' => $mediaPaths,
            'modules' => $request->modules,
        ]);

        return redirect()->route('admin.detail_courses.index')->with('success', 'Detail kursus berhasil diperbarui.');
    }

    public function destroy(DetailCourse $detailCourse)
    {
        if ($detailCourse->media && is_array($detailCourse->media)) {
            foreach ($detailCourse->media as $file) {
                if (Storage::disk('public')->exists($file)) {
                    Storage::disk('public')->delete($file);
                }
            }
        }

        $detailCourse->delete();

        return redirect()->route('admin.detail_courses.index')->with('success', 'Detail kursus berhasil dihapus.');
    }
}
