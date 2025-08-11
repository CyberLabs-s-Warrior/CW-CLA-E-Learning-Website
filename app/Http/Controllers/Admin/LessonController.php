<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\DetailCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
    public function index()
    {
        $lessons = Lesson::with('course')->latest()->paginate(10);
        return view('admin.lessons.index', compact('lessons'));
    }
    public function create()
    {
        $courses = DetailCourse::all();
        return view('admin.lessons.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'detail_courses_id' => 'required|exists:detail_courses,id',
            'module_name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,mov,avi|max:10240',
        ]);

        $mediaPath = null;
        if ($request->hasFile('media')) {
            $mediaPath = $request->file('media')->store('lessons', 'public');
        }

        Lesson::create([
            'detail_courses_id' => $request->detail_courses_id,
            'module_name' => $request->module_name,
            'title' => $request->title,
            // 'content' => $request->content,
            'content' => $request->input('content'),
            'media' => $mediaPath,
        ]);

        return redirect()->route('admin.lessons.index')->with('success', 'Materi berhasil ditambahkan.');
    }

    public function edit(Lesson $lesson)
    {
        $courses = DetailCourse::all();

        // Ambil modul dari course yang sesuai
        $modules = [];
        if ($lesson->detail_courses_id) {
            $course = DetailCourse::find($lesson->detail_courses_id);
            $modules = $course->modules ?? [];
        }

        return view('admin.lessons.edit', compact('lesson', 'courses', 'modules'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        $request->validate([
            'detail_courses_id' => 'required|exists:detail_courses,id',
            'module_name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,mov,avi|max:10240',
        ]);

        $mediaPath = $lesson->media;
        if ($request->hasFile('media')) {
            if ($mediaPath && Storage::disk('public')->exists($mediaPath)) {
                Storage::disk('public')->delete($mediaPath);
            }

            $mediaPath = $request->file('media')->store('lessons', 'public');
        }

        $lesson->update([
            'detail_courses_id' => $request->detail_courses_id,
            'module_name' => $request->module_name,
            'title' => $request->title,
            // 'content' => $request->content,
            'content' => $request->input('content'),
            'media' => $mediaPath,
        ]);

        return redirect()->route('admin.lessons.index')->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy(Lesson $lesson)
    {
        if ($lesson->media && Storage::disk('public')->exists($lesson->media)) {
            Storage::disk('public')->delete($lesson->media);
        }

        $lesson->delete();
        return redirect()->route('admin.lessons.index')->with('success', 'Materi berhasil dihapus.');
    }

    public function show(Lesson $lesson)
    {
        return view('admin.lessons.show', compact('lesson'));
    }

}
