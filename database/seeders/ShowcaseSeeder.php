<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Showcase;

class ShowcaseSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil user dengan role student (Spatie)
        $student = User::role('student')->first();

        // Kalau belum ada student, kasih warning
        if (!$student) {
            $this->command->warn('Belum ada user dengan role student. Buat dulu minimal 1 student.');
            return;
        }

        // Insert data contoh showcase
        Showcase::create([
            'user_id'     => $student->id,
            'title'       => 'Website Portfolio',
            'description' => 'Website personal menggunakan Laravel + TailwindCSS. Berisi halaman Home, About, dan Projects.',
            'image_path'  => 'showcase/portfolio.jpg', // contoh path gambar
        ]);

        Showcase::create([
            'user_id'     => $student->id,
            'title'       => 'Dashboard Admin E-Learning',
            'description' => 'Dashboard dengan fitur role-based access, CRUD modul, dan manajemen user.',
            'image_path'  => 'showcase/dashboard.jpg', // contoh path gambar
        ]);

        $this->command->info('✅ ShowcaseSeeder berhasil dijalankan. 2 data contoh dibuat.');
    }
}
