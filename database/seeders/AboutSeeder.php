<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\About;

class AboutSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'section' => 'visi',
                'title' => 'Visi Kami',
                'description' => 'Menjadi platform pembelajaran terbaik di Indonesia.',
                'image' => 'about/visi.jpg',
            ],
            [
                'section' => 'misi',
                'title' => 'Misi Kami',
                'description' => 'Menyediakan materi berkualitas dan pelatihan untuk semua kalangan.',
                'image' => 'about/misi.jpg',
            ],
            [
                'section' => 'profil',
                'title' => 'Profil Perusahaan',
                'description' => 'Kami adalah tim yang berdedikasi dalam pengembangan pendidikan digital.',
                'image' => 'about/profil.jpg',
            ],
        ];

        foreach ($data as $item) {
            About::create($item);
        }
    }
}
