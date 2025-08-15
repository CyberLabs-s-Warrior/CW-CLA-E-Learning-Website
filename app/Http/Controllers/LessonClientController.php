<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class LessonClientController extends Controller
{
    public function index($courseName)
    {
        // Cari course berdasarkan nama beserta lessons
        $course = Course::with('lessons')->where('name', $courseName)->first();

        if (!$course) {
            abort(404, 'Course tidak ditemukan');
        }

        $lessons = $course->lessons;

        return view('clients.lesson.index', compact('lessons', 'course'));
    }
}
