<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;

class TestimoniClientController extends Controller
{
    public function index()
    {
        // Ambil testimoni yang published + eager load user
        $testimonials = Testimonial::query()
            ->with(['user' => function ($q) {
                $q->select('id', 'name'); // ambil hanya yang perlu
            }])
            ->where('is_published', true)
            ->latest()
            ->get();

        return view('guest.testimoni.index', compact('testimonials'));
    }
}
