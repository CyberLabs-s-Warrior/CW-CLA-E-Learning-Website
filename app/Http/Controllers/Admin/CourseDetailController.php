<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseDetail;
use Illuminate\Http\Request;

class CourseDetailController extends Controller
{
    public function index()
    {
        $details = CourseDetail::with(['course.level', 'course.lessons', 'instructorProfile.user'])
            ->paginate(10);

        $courses = Course::with('detail')->get();

        return view('admin.detail.index', compact('details', 'courses'));
    }

    public function create()
    {
        $courseList = Course::pluck('name', 'id');

        $instructors = \App\Models\InstructorProfile::with('user')
            ->where('is_published', true)
            ->orderBy('sort_order')
            ->get();

        return view('admin.detail.create', compact('courseList', 'instructors'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'instructors' => 'required|array',
            'instructors.*' => 'exists:instructor_profiles,id',
            'description' => 'nullable|string',
            'outcomes' => 'nullable|string',
        ]);

        $detail = CourseDetail::create([
            'course_id' => $request->course_id,
            'description' => $request->description,
            'outcomes' => $request->outcomes,
        ]);

        $detail->instructors()->sync($request->instructors);

        return redirect()->route('admin.detail.index')
            ->with('success', 'Detail kursus berhasil ditambahkan.');
    }

    public function show(CourseDetail $detail)
    {
        return view('admin.detail.show', ['detail' => $detail]);
    }

    public function edit(CourseDetail $detail)
    {
        $courseList = Course::pluck('name', 'id');

        $instructors = \App\Models\InstructorProfile::with('user')
            ->where('is_published', true)
            ->orderBy('sort_order')
            ->get();

        return view('admin.detail.edit', compact('detail', 'courseList', 'instructors'));
    }



    public function update(Request $request, CourseDetail $detail)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'instructors' => 'required|array',
            'instructors.*' => 'exists:instructor_profiles,id',
            'description' => 'nullable|string',
            'outcomes' => 'nullable|string',
        ]);

        $detail->update([
            'course_id' => $request->course_id,
            'description' => $request->description,
            'outcomes' => $request->outcomes,
        ]);

        $detail->instructors()->sync($request->instructors);

        return redirect()->route('admin.detail.index')
            ->with('success', 'Detail kursus berhasil diperbarui.');
    }

    public function destroy(CourseDetail $detail)
    {
        $detail->delete();
        return redirect()->route('admin.detail.index')
            ->with('success', 'Detail kursus berhasil dihapus.');
    }

    /**
     * AJAX endpoint untuk ambil data course lengkap
     */
    public function getCourseInfo($id)
    {
        $course = Course::with(['lessons', 'instructors', 'detail', 'level'])
            ->findOrFail($id);

        return response()->json([
            'course' => [
                'id' => $course->id,
                'name' => $course->name,
                'image_url' => $course->img ? asset('storage/' . $course->img) : null,
                'duration' => $course->formatted_duration ?? 'Belum ditentukan',
                'students_count' => $course->students_count ?? 0,
                'level' => $course->level ? $course->level->level : 'Tidak ada level',
            ],
            'lessons' => $course->lessons->map(function ($lesson) {
                return [
                    'id' => $lesson->id,
                    'title' => $lesson->title,
                    'duration' => $lesson->duration ?? 0,
                    'duration_formatted' => $lesson->formatted_duration ?? 'Belum ditentukan',
                ];
            }),
            'instructors' => $course->instructors->map(function ($ins) {
                return [
                    'id' => $ins->id,
                    'name' => $ins->name,
                ];
            }),
        ]);
    }

}
