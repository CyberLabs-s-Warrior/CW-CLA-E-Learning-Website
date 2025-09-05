<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class LessonClientController extends Controller
{
    public function index($slug, Request $request)
    {
        // Ambil course beserta relasi lessons & instructors
        $course = Course::with(['lessons', 'instructors'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Tentukan lesson aktif dari query ?lesson=id atau ambil pertama
        $lesson = $course->lessons
            ->where('id', $request->get('lesson'))
            ->first()
            ?? $course->lessons->first();

        return view('student.lesson.index', compact('course', 'lesson'));
    }
}
