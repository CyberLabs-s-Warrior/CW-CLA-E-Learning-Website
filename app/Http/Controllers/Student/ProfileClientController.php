<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;  

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileClientController extends Controller
{
      public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->hasRole('student') && !$user->profile) {
            return redirect()->route('pendataan.index');
        }

        // Active courses
        $activeCourses = $user->activeCourses();   // collection of Course
        $activeCoursesCount = $activeCourses->count();

        // ==== NEW: pilih course via ?course=ID ====
        $selectedCourseId = $request->integer('course');
        $selectedCourse   = null;
        $overviewMode     = 'overall'; // 'overall' | 'single'
        $overviewPercent  = 0;
        $overviewLabel    = 'Rata-rata semua course aktif';

        if ($activeCoursesCount > 0) {
            if ($selectedCourseId) {
                $selectedCourse = $activeCourses->firstWhere('id', $selectedCourseId);
            }

            if ($selectedCourse) {
                // progress khusus course terpilih
                $overviewPercent = $selectedCourse->progressPercentFor($user);
                $overviewMode    = 'single';
                $overviewLabel   = 'Progress: ' . $selectedCourse->name;
            } else {
                // progress rata-rata semua active course (default)
                $sum = 0;
                foreach ($activeCourses as $c) {
                    $sum += $c->progressPercentFor($user);
                }
                $overviewPercent = (int) round($sum / $activeCoursesCount);
            }
        }

        // Continue Learning (tetap seperti sebelumnya)
        $continueLearning = $activeCourses->map(function ($c) use ($user) {
            return [
                'course'        => $c,
                'nextLesson'    => $c->nextIncompleteLessonFor($user),
                'progress'      => $c->progressPercentFor($user),
                'lessons_count' => $c->lessons()->count(),
            ];
        })->sortByDesc('progress')->take(6)->values();

        // ==== NEW: jika memilih course tertentu, kamu bisa batasi continueLearning ke course itu saja (opsional) ====
        if ($selectedCourse) {
            $continueLearning = $continueLearning
                ->filter(fn($it) => $it['course']->id === $selectedCourse->id)
                ->values();
        }

        return view('student.dashboard.index', [
            'user'                  => $user,
            'activeCoursesCount'    => $activeCoursesCount,
            'overviewPercent'       => $overviewPercent,  // NEW: ganti nama var biar jelas
            'overviewMode'          => $overviewMode,     // NEW
            'overviewLabel'         => $overviewLabel,    // NEW
            'continueLearning'      => $continueLearning,
            'activeCourses'         => $activeCourses,    // NEW: untuk dropdown
            'selectedCourseId'      => $selectedCourseId, // NEW
        ]);
    }
}
