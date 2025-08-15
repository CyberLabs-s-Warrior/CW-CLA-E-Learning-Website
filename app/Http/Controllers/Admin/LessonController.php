<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\DetailCourse;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
    public function index()
    {
        $lessons = Lesson::with(['detailCourse.course'])->latest()->paginate(10);
        return view('admin.lessons.index', compact('lessons'));
    }

    public function create()
    {

        // Ambil semua kursus
        $courses = Course::all();
        return view('admin.lessons.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'detail_courses_id' => 'required|exists:detail_courses,id',
            'module_name'       => 'required|string|max:255',
            'title'             => 'required|string|max:255',
            'content'           => 'nullable|string',
            'media'             => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,mov,avi|max:10240',
        ]);

        $lessonData = $request->only('detail_courses_id', 'module_name', 'title', 'content');

        if ($request->hasFile('media')) {
            $lessonData['media'] = $request->file('media')->store('lessons', 'public');
        }

        Lesson::create($lessonData);

        return redirect()->route('admin.lessons.index')
            ->with('success', 'Materi berhasil ditambahkan');
    }

    public function edit(Lesson $lesson)
    {
        $courses = Course::select('id', 'name')->get();

        $modules = [];
        if ($lesson->detail_courses_id) {
            $detailCourse = DetailCourse::find($lesson->detail_courses_id);
            if ($detailCourse && is_array($detailCourse->modules)) {
                $modules = $detailCourse->modules;
            } elseif ($detailCourse) {
                $modules = json_decode($detailCourse->modules, true) ?? [];
            }
        }

        return view('admin.lessons.edit', compact('lesson', 'courses', 'modules'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        $request->validate([
            'detail_courses_id' => 'required|exists:detail_courses,id',
            'module_name'       => 'required|string|max:255',
            'title'             => 'required|string|max:255',
            'content'           => 'nullable|string',
            'media'             => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,mov,avi|max:10240',
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
            'module_name'       => $request->module_name,
            'title'             => $request->title,
            'content'           => $request->input('content'),
            'media'             => $mediaPath,
        ]);

        return redirect()->route('admin.lessons.index')
            ->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy(Lesson $lesson)
    {
        if ($lesson->media && Storage::disk('public')->exists($lesson->media)) {
            Storage::disk('public')->delete($lesson->media);
        }

        $lesson->delete();
        return redirect()->route('admin.lessons.index')
            ->with('success', 'Materi berhasil dihapus.');
    }

    public function show(Lesson $lesson)
    {
        return view('admin.lessons.show', compact('lesson'));
    }

    /**
     * Ambil modul berdasarkan course ID (AJAX)
     */
    public function getModules($courseId)
    {
        $details = DetailCourse::where('course_id', $courseId)->get();
        $modules = [];

        foreach ($details as $detail) {
            $modArray = is_array($detail->modules)
                ? $detail->modules
                : json_decode($detail->modules, true);

            if (is_array($modArray)) {
                foreach ($modArray as $modName) {
                    $modules[] = [
                        'detail_courses_id' => $detail->id,
                        'module_name'       => $modName,
                    ];
                }
            }
        }

        return response()->json($modules);
    }
}
