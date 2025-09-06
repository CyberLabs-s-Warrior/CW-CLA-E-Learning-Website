<?php

namespace App\Http\Controllers\Guest;
use App\Http\Controllers\Controller; // <- penting

use Illuminate\Http\Request;

// app/Http/Controllers/Guest/HomeClientController.php
namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;

class HomeClientController extends Controller
{
    public function index()
    {
        $testimonials   = Testimonial::published()
                            ->with('user:id,name')
                            ->latest()
                            ->take(6)
                            ->get();

        $testiHasMore   = Testimonial::published()->count() > 6;

        return view('guest.home.index', compact('testimonials','testiHasMore'));
    }
}
