<?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use App\Models\Lesson;
    use App\Models\Course;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;
    use getID3;

    class LessonController extends Controller
    {
public function index(Request $request)
{
    $query = Lesson::with('course');

    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('course_id')) {
        $query->where('course_id', $request->course_id);
    }

    $lessons = $query
        ->orderBy('course_id')
        ->orderBy('module_name')
        ->orderBy('order')
        ->paginate(10);

    $courses = \App\Models\Course::orderBy('name')->get();

    return view('admin.lessons.index', compact('lessons', 'courses'));
}



        public function create()
        {
            $courses = Course::all();
            return view('admin.lessons.create', compact('courses'));
        }

        public function store(Request $request)
        {
            $request->validate([
                'course_id' => 'required|exists:courses,id',
                'module_name' => 'required|string|max:255',
                'title' => 'required|string|max:255',
                'content' => 'nullable|string',
                'media' => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,mov,avi|max:10240',
                'duration_hours' => 'nullable|integer|min:0',
                'duration_minutes' => 'nullable|integer|min:0|max:59',
                'duration_seconds' => 'nullable|integer|min:0|max:59',
                'is_preview' => 'nullable|boolean',
            ]);

            // === Slug unik ===
            $baseSlug = Str::slug($request->title);
            $slug = $baseSlug;
            $counter = 1;
            while (
                \App\Models\Lesson::where('course_id', $request->course_id)
                    ->where('slug', $slug)
                    ->exists()
            ) {
                $slug = $baseSlug . '-' . $counter++;
            }

            // === Media dan durasi ===
            $mediaPath = null;
            $duration = 0;

            if ($request->hasFile('media')) {
                $mediaPath = $request->file('media')->store('lessons', 'public');

                $extension = $request->file('media')->extension();
                if (in_array($extension, ['mp4', 'mov', 'avi'])) {
                    $getID3 = new getID3;
                    $fileInfo = $getID3->analyze($request->file('media')->getPathname());
                    if (isset($fileInfo['playtime_seconds'])) {
                        $duration = (int) ceil($fileInfo['playtime_seconds']);
                    }
                }
            }

            // Jika bukan video → pakai input manual
            if (!$duration) {
                $hours = (int) $request->input('duration_hours', 0);
                $minutes = (int) $request->input('duration_minutes', 0);
                $seconds = (int) $request->input('duration_seconds', 0);
                $duration = ($hours * 3600) + ($minutes * 60) + $seconds;
            }

            // === Tentukan order otomatis per modul ===
            $lastLesson = \App\Models\Lesson::where('course_id', $request->course_id)
                ->where('module_name', $request->module_name)
                ->orderByDesc('order')
                ->first();

            $order = $lastLesson ? $lastLesson->order + 1 : 1;

            // === Simpan Lesson ===
            \App\Models\Lesson::create([
                'course_id' => $request->course_id,
                'module_name' => $request->module_name,
                'title' => $request->title,
                'slug' => $slug,
                'content' => $request->input('content'),
                'media' => $mediaPath,
                'duration' => $duration,
                'is_preview' => $request->boolean('is_preview', false),
                'order' => $order,
            ]);

            return redirect()->route('admin.lessons.index')
                ->with('success', 'Materi berhasil ditambahkan.');
        }



        public function edit(Lesson $lesson)
        {
            $courses = Course::select('id', 'name')->get();

            // Hitung jam/menit/detik hanya jika media bukan video
            $hours = $minutes = $seconds = 0;
            if ($lesson->duration && !preg_match('/\.(mp4|mov|avi)$/i', $lesson->media ?? '')) {
                $hours = intdiv($lesson->duration, 3600);
                $minutes = intdiv($lesson->duration % 3600, 60);
                $seconds = $lesson->duration % 60;
            }

            return view('admin.lessons.edit', compact('lesson', 'courses', 'hours', 'minutes', 'seconds'));
        }

        public function update(Request $request, Lesson $lesson)
        {
            $request->validate([
                'course_id' => 'required|exists:courses,id',
                'module_name' => 'required|string|max:255',
                'title' => 'required|string|max:255',
                'content' => 'nullable|string',
                'media' => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,mov,avi|max:10240',
                'duration_hours' => 'nullable|integer|min:0',
                'duration_minutes' => 'nullable|integer|min:0|max:59',
                'duration_seconds' => 'nullable|integer|min:0|max:59',
                'is_preview' => 'nullable|boolean',
            ]);

            $mediaPath = $lesson->media;
            $duration = $lesson->duration;

            // Generate slug unik
            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $counter = 1;
            while (
                Lesson::where('course_id', $request->course_id)
                    ->where('slug', $slug)
                    ->where('id', '!=', $lesson->id)
                    ->exists()
            ) {
                $slug = $originalSlug . '-' . $counter++;
            }

            // Jika ada media baru
            if ($request->hasFile('media')) {
                if ($mediaPath && Storage::disk('public')->exists($mediaPath)) {
                    Storage::disk('public')->delete($mediaPath);
                }
                $mediaPath = $request->file('media')->store('lessons', 'public');

                $extension = $request->file('media')->extension();
                if (in_array($extension, ['mp4', 'mov', 'avi'])) {
                    $getID3 = new \getID3;
                    $fileInfo = $getID3->analyze($request->file('media')->getPathname());
                    if (isset($fileInfo['playtime_seconds'])) {
                        $duration = (int) ceil($fileInfo['playtime_seconds']);
                    }
                } else {
                    // Reset manual duration jika image
                    $hours = (int) $request->input('duration_hours', 0);
                    $minutes = (int) $request->input('duration_minutes', 0);
                    $seconds = (int) $request->input('duration_seconds', 0);
                    $duration = ($hours * 3600) + ($minutes * 60) + $seconds;
                }
            } else {
                // Kalau media tidak diganti → tetap pakai durasi lama (atau override manual kalau image)
                if ($request->filled(['duration_hours', 'duration_minutes', 'duration_seconds'])) {
                    $hours = (int) $request->input('duration_hours', 0);
                    $minutes = (int) $request->input('duration_minutes', 0);
                    $seconds = (int) $request->input('duration_seconds', 0);
                    $duration = ($hours * 3600) + ($minutes * 60) + $seconds;
                }
            }

            $lesson->update([
                'course_id' => $request->course_id,
                'module_name' => $request->module_name,
                'title' => $request->title,
                'slug' => $slug,
                'content' => $request->input('content'),
                'media' => $mediaPath,
                'duration' => $duration,
                'is_preview' => $request->boolean('is_preview', false),
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
            // Ambil semua lesson di modul yang sama dan urutkan berdasarkan order
            $lessonsInModule = Lesson::where('course_id', $lesson->course_id)
                ->where('module_name', $lesson->module_name)
                ->orderBy('order')
                ->get();

            return view('admin.lessons.show', compact('lesson', 'lessonsInModule'));
        }


        /**
         * Ambil modul berdasarkan course ID (AJAX)
         */
        public function getModules($courseId)
        {
            $modules = Lesson::where('course_id', $courseId)
                ->select('module_name')
                ->distinct()
                ->get();

            return response()->json($modules);
        }
    }
