<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\LessonProgress;
use Illuminate\Support\Facades\Auth;

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
     public function complete(Lesson $lesson, Request $request)
    {
        $user = Auth::user();
        $course = $lesson->course;

        // Otorisasi sederhana: user harus punya akses (paid/enrolled)
        $hasAccess = $user->activeCoursesQuery()->where('courses.id',$course->id)->exists();
        if (!$hasAccess) {
            abort(403, 'Anda tidak memiliki akses ke kursus ini.');
        }

        LessonProgress::updateOrCreate(
            ['user_id'=>$user->id,'lesson_id'=>$lesson->id],
            ['course_id'=>$course->id,'is_completed'=>true,'completed_at'=>now()]
        );

        // Cari lesson berikutnya yang belum selesai
        $next = $course->nextIncompleteLessonFor($user);

        // Kalau ada next → arahkan ke lesson berikutnya, kalau tidak → kembali ke detail course
        if ($next) {
            return redirect()
                ->route('lesson.index', [$course->slug, 'lesson'=>$next->id])
                ->with('status','Mantap! Modul ditandai selesai. Lanjut ke modul berikutnya.');
        } else {
            return redirect()
                ->route('detail.index', $course->slug)
                ->with('status','Selamat! Kamu telah menyelesaikan semua modul kursus ini 🎉');
        }
    }
}
