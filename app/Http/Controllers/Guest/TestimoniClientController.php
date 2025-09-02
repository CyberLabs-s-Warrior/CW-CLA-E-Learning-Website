<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;

class TestimoniClientController extends Controller
{
    public function index()
    {
        $testimonials = [
            [
                'name' => 'Rina',
                'role' => 'Mahasiswa',
                'text' => 'Platform ini luar biasa! Materinya jelas dan instruktur ramah.',
                'img' => 'https://i.pravatar.cc/150?img=1'
            ],
            [
                'name' => 'Dimas',
                'role' => 'Frontend Developer',
                'text' => 'Sertifikatnya membantu saya melamar kerja di perusahaan IT.',
                'img' => 'https://i.pravatar.cc/150?img=2'
            ],
            [
                'name' => 'Putri',
                'role' => 'UI/UX Designer',
                'text' => 'Kursusnya lengkap dan mudah dipahami bahkan untuk pemula.',
                'img' => 'https://i.pravatar.cc/150?img=3'
            ],
        ];

        return view('guest.testimoni.index', compact('testimonials'));
    }
}
