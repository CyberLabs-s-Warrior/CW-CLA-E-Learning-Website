<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Models\InstructorProfile;

class HomeClientController extends Controller
{
    public function index()
    {
        // 3 instruktur teratas untuk ditampilkan di beranda
        $topInstructors = InstructorProfile::query()
            ->with(['user:id,name'])
            ->where('is_published', true)
            ->whereHas('user')
            ->orderBy('sort_order')
            ->orderByDesc('updated_at')
            ->take(3)
            ->get();

        // testimoni seperti sebelumnya
        $testimonials = Testimonial::published()
            ->with('user:id,name')
            ->latest()
            ->take(6)
            ->get();

        $testiHasMore = Testimonial::published()->count() > 6;

        return view('guest.home.index', compact('topInstructors', 'testimonials', 'testiHasMore'));
    }
}
