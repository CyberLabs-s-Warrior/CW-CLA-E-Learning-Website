<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;

class KatalogClientController extends Controller
{
   public function index()
{
    $category = request('category');
    $price    = request('price');
    $level    = request('level');

    $courses = collect([
        [
            'title' => 'Belajar React',
            'category' => 'frontend',
            'img' => asset('images/courses/react.jpg'),
            'desc' => 'Belajar React dari dasar hingga mahir.',
            'level' => 'Beginner',
            'price' => 'Free',
            'modules' => 10,
            'duration' => '8 jam',
            'students' => 120,
        ],
        [
            'title' => 'Laravel Dasar',
            'category' => 'web',
            'img' => asset('images/courses/laravel.jpg'),
            'desc' => 'Belajar Laravel untuk membangun aplikasi web.',
            'level' => 'Intermediate',
            'price' => 'Paid',
            'modules' => 20,
            'duration' => '15 jam',
            'students' => 300,
        ],
    ])
    ->when($category, fn($q) => $q->where('category', $category))
    ->when($price, fn($q) => $q->where('price', ucfirst($price)))
    ->when($level, fn($q) => $q->where('level', ucfirst($level)))
    ->values()->all();

    return view('guest.katalog.index', compact('courses'));
}

}
