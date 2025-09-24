<?php

namespace Database\Seeders;

use App\Models\ForumCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ForumCategorySeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['name' => 'Pengumuman',  'description' => 'Info penting dari tim', 'sort_order' => 1, 'is_private' => false],
            ['name' => 'Tanya Materi','description' => 'Diskusi & QnA seputar modul/kursus', 'sort_order' => 2, 'is_private' => false],
            ['name' => 'Tips & Karier','description' => 'Sharing pengalaman & lowongan', 'sort_order' => 3, 'is_private' => false],
            ['name' => 'Off-topic',   'description' => 'Ngobrol santai', 'sort_order' => 4, 'is_private' => false],
        ];

        foreach ($rows as $r) {
            ForumCategory::updateOrCreate(
                ['slug' => Str::slug($r['name'])],
                array_merge($r, ['slug' => Str::slug($r['name'])])
            );
        }
    }
}
