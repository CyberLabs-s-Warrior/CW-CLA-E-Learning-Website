<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

// Models
use App\Models\About;
use App\Models\Contact;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseLevel;
use App\Models\CoursePriceRange;
use App\Models\CourseDetail;
use App\Models\Lesson;
use App\Models\Showcase;
use App\Models\Testimonial;
use App\Models\InstructorProfile;
use App\Models\ForumCategory;
use App\Models\ForumThread;
use App\Models\ForumPost;

class DashboardController extends Controller
{
    /**
     * Dashboard admin (dinamis sesuai permission).
     * Superadmin => full widgets.
     */
    public function index()
    {
        $user = Auth::user();
        $isSuper = $this->isSuperadmin($user);

        // Peta permission (satu sumber kebenaran)
        $can = [
            'about'      => $isSuper || $user->can('kelola_about'),
            'contact'    => $isSuper || $user->can('kelola_contact'),
            'course'     => $isSuper || $user->can('kelola_course'),
            'showcase'   => $isSuper || $user->can('kelola_showcase'),
            'testimonial'=> $isSuper || $user->can('kelola_testimoni'),
            'instructor' => $isSuper || $user->can('kelola_instructor'),
            'forum'      => $isSuper || $user->can('kelola_forum'),
        ];

        $tahun      = now()->year;
        $awalBulan  = now()->copy()->startOfMonth();
        $akhirBulan = now()->copy()->endOfMonth();

        // =========================
        // KPI / COUNTS (conditional)
        // =========================
        $kpi = [
            // ABOUT
            'about_total'         => $can['about']      ? About::count() : null,
            'about_sections'      => $can['about']      ? About::query()->distinct('section')->count('section') : null,

            // CONTACT (1 baris konfigurasi saja biasanya)
            'contact_is_configured' => $can['contact']  ? (Contact::query()->exists()) : null,
            'contact_social_filled' => $can['contact']  ? $this->countContactSocialFilled() : null,

            // COURSE
            'course_total'        => $can['course']     ? Course::count() : null,
            'course_free'         => $can['course']     ? Course::free()->count() : null,
            'course_paid'         => $can['course']     ? Course::paid()->count() : null,
            'lesson_total'        => $can['course']     ? Lesson::count() : null,
            'category_total'      => $can['course']     ? CourseCategory::count() : null,

            // SHOWCASE
            'showcase_total'      => $can['showcase']   ? Showcase::count() : null,

            // TESTIMONIAL
            'testimonial_total'   => $can['testimonial']? Testimonial::count() : null,
            'testimonial_pub'     => $can['testimonial']? Testimonial::published()->count() : null,

            // INSTRUCTOR
            'instructor_total'    => $can['instructor'] ? InstructorProfile::count() : null,

            // FORUM
            'forum_cat_total'     => $can['forum']      ? ForumCategory::count() : null,
            'forum_thread_total'  => $can['forum']      ? ForumThread::count() : null,
            'forum_post_total'    => $can['forum']      ? ForumPost::count() : null,
            'forum_locked_total'  => $can['forum']      ? ForumThread::where('is_locked', true)->count() : null,
        ];

        // =======================================
        // Ringkasan bulan ini (conditional counts)
        // =======================================
        $bulanIni = [
            'course' => $can['course']
                ? Course::whereBetween('created_at', [$awalBulan, $akhirBulan])->count()
                : null,
            'lesson' => $can['course']
                ? Lesson::whereBetween('created_at', [$awalBulan, $akhirBulan])->count()
                : null,
            'showcase' => $can['showcase']
                ? Showcase::whereBetween('created_at', [$awalBulan, $akhirBulan])->count()
                : null,
            'testimonial' => $can['testimonial']
                ? Testimonial::whereBetween('created_at', [$awalBulan, $akhirBulan])->count()
                : null,
            'forum_thread' => $can['forum']
                ? ForumThread::whereBetween('created_at', [$awalBulan, $akhirBulan])->count()
                : null,
            'forum_post' => $can['forum']
                ? ForumPost::whereBetween('created_at', [$awalBulan, $akhirBulan])->count()
                : null,
        ];

        // ==========================
        // Tren bulanan per fitur (12)
        // ==========================
        $series = [
            'course'       => $can['course']     ? $this->seriesTahunan(Course::class, $tahun)      : [],
            'lesson'       => $can['course']     ? $this->seriesTahunan(Lesson::class, $tahun)      : [],
            'showcase'     => $can['showcase']   ? $this->seriesTahunan(Showcase::class, $tahun)    : [],
            'testimonial'  => $can['testimonial']? $this->seriesTahunan(Testimonial::class, $tahun) : [],
            'forum_thread' => $can['forum']      ? $this->seriesTahunan(ForumThread::class, $tahun) : [],
            'forum_post'   => $can['forum']      ? $this->seriesTahunan(ForumPost::class, $tahun)   : [],
        ];

        // ==========================
        // Latest (list ringkas)
        // ==========================
        $latest = [
            'courses'   => $can['course']     ? Course::latest()->take(5)->get(['id','name','slug','created_at']) : collect(),
            'lessons'   => $can['course']     ? Lesson::latest()->take(5)->get(['id','title','module_name','created_at']) : collect(),
            'showcases' => $can['showcase']   ? Showcase::latest()->take(5)->get(['id','title','created_at']) : collect(),
            'testis'    => $can['testimonial']? Testimonial::latest()->take(5)->get(['id','content','is_published','created_at']) : collect(),
            'threads'   => $can['forum']      ? ForumThread::latest()->take(5)->get(['id','title','is_locked','created_at']) : collect(),
            'posts'     => $can['forum']      ? ForumPost::latest()->take(5)->get(['id','thread_id','created_at']) : collect(),
        ];

        return view('admin.dashboard.index', [
            'isSuper'   => $isSuper,
            'can'       => $can,
            'tahun'     => $tahun,
            'kpi'       => $kpi,
            'bulanIni'  => $bulanIni,
            'series'    => $series,
            'latest'    => $latest,
        ]);
    }

    private function isSuperadmin($user): bool
    {
        // fleksibel: boolean kolom + role Spatie
        return (bool)($user->is_superadmin ?? false) || $user->hasRole('superadmin');
    }

    private function seriesTahunan(string $modelClass, int $tahun): array
    {
        /** @var \Illuminate\Database\Eloquent\Builder $q */
        $byMonth = $modelClass::whereYear('created_at', $tahun)
            ->selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->groupBy('bulan')->pluck('total', 'bulan')->toArray();

        $out = [];
        for ($i = 1; $i <= 12; $i++) $out[] = $byMonth[$i] ?? 0;
        return $out;
    }

    private function countContactSocialFilled(): ?int
    {
        $contact = Contact::first();
        if (!$contact) return null;

        $keys = [
            'social_facebook','social_instagram','social_tiktok','social_x',
        ];
        $cnt = 0;
        foreach ($keys as $k) {
            if (!empty($contact->{$k})) $cnt++;
        }
        return $cnt;
    }
}
