<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;

class InstrukturClientController extends Controller
{
    public function index()
    {
        $instructors = [
            [
                'name' => 'Budi Santoso',
                'skill' => 'Fullstack Developer',
                'img' => 'https://i.pravatar.cc/150?img=10'
            ],
            [
                'name' => 'Siti Rahma',
                'skill' => 'UI/UX Designer',
                'img' => 'https://i.pravatar.cc/150?img=11'
            ],
            [
                'name' => 'Andi Wijaya',
                'skill' => 'Data Scientist',
                'img' => 'https://i.pravatar.cc/150?img=12'
            ],
        ];

        return view('guest.instruktur.index', compact('instructors'));
    }
}
