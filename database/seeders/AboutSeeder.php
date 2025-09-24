<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\About;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AboutSeeder extends Seeder
{
    /**
     * Salin file dari public ke storage public/about_images
     * @param  string      $publicPath   contoh: 'image/banner.jpg'
     * @param  string|null $destName     contoh: 'hero.jpg' (opsional)
     * @return string|null path relatif untuk disimpan ke DB, contoh: 'about_images/hero.jpg'
     */
    private function storeFromPublic(string $publicPath, ?string $destName = null): ?string
    {
        $full = public_path($publicPath);
        if (!file_exists($full)) {
            return null; // biar fallback ke default
        }

        // pastikan folder ada
        if (!Storage::disk('public')->exists('about_images')) {
            Storage::disk('public')->makeDirectory('about_images');
        }

        $ext = pathinfo($full, PATHINFO_EXTENSION) ?: 'jpg';
        $filename = $destName ?: (Str::uuid()->toString() . '.' . $ext);
        $dest = 'about_images/' . $filename;

        // salin isi file
        Storage::disk('public')->put($dest, file_get_contents($full));
        return $dest;
    }

    public function run(): void
    {
        // Opsional: kosongkan dulu (hati-hati jika production)
        // About::query()->truncate();

        // Siapkan path gambar (gunakan yang ada, atau biar null untuk fallback)
        $heroImage   = $this->storeFromPublic('image/banner.jpg', 'hero.jpg');       // fallback hero jika ada
        $introImage  = $this->storeFromPublic('image/si-imut.png', 'intro.png');     // contoh
        $visiImage   = $this->storeFromPublic('image/laptop1.png', 'visi.png');      // contoh
        $misiImage   = $this->storeFromPublic('image/laptop2.png', 'misi.png');      // contoh

        $data = [
            // ===== HERO (opsional) =====
            [
                'section'       => 'hero_title',
                'title'         => 'ABOUT US',
                'description'   => 'Temui misi dan cerita kami dalam membangun ekosistem pembelajaran digital.',
                'image'         => null,
                'display_order' => 1,
            ],
            [
                'section'       => 'hero_image',
                'title'         => null,
                'description'   => null,
                'image'         => $heroImage, // null -> front-end pakai asset('image/banner.jpg')
                'display_order' => 2,
            ],

            // ===== INTRO =====
            [
                'section'       => 'about_intro',
                'title'         => 'E-Learning yang Sederhana, Kuat, & Aksesibel',
                'description'   => '<p>Platform kami dirancang agar mudah digunakan oleh siswa dan pengajar, dengan kurasi materi yang relevan serta fitur evaluasi yang transparan.</p><ul><li>Konten berkualitas</li><li>Antarmuka ramah pengguna</li><li>Skalabel untuk kebutuhan sekolah & organisasi</li></ul>',
                'image'         => $introImage,
                'display_order' => 10,
            ],

            // ===== VISI & MISI =====
            [
                'section'       => 'visi',
                'title'         => 'Visi Kami',
                'description'   => 'Menjadi platform pembelajaran digital terbaik di Indonesia yang mendorong pemerataan akses pendidikan.',
                'image'         => $visiImage,
                'display_order' => 20,
            ],
            [
                'section'       => 'misi',
                'title'         => 'Misi Kami',
                'description'   => '<p>Menyediakan materi berkualitas, pelatihan berkelanjutan, dan pengalaman belajar yang inklusif untuk semua kalangan.</p>',
                'image'         => $misiImage,
                'display_order' => 21,
            ],

            // ===== PROFIL (contoh generic section) =====
            [
                'section'       => 'profil',
                'title'         => 'Profil Perusahaan',
                'description'   => 'Kami adalah tim yang berdedikasi dalam pengembangan pendidikan digital, memadukan teknologi dengan pedagogi modern.',
                'image'         => null, // boleh tanpa gambar
                'display_order' => 30,
            ],

            // ===== SEJARAH (multi-item) =====
            [
                'section'       => 'sejarah',
                'title'         => '2022 — Riset & Validasi',
                'description'   => 'Memulai riset UX dan validasi kurikulum bersama mitra sekolah.',
                'image'         => null,
                'display_order' => 40,
            ],
            [
                'section'       => 'sejarah',
                'title'         => '2023 — Pilot Project',
                'description'   => 'Peluncuran pilot dengan kelas terbatas, perbaikan UI/UX berdasarkan umpan balik.',
                'image'         => null,
                'display_order' => 41,
            ],
            [
                'section'       => 'sejarah',
                'title'         => '2024 — Skalasi Konten',
                'description'   => 'Menambah katalog kursus, integrasi fitur evaluasi dan sertifikat.',
                'image'         => null,
                'display_order' => 42,
            ],
        ];

        foreach ($data as $item) {
            About::create($item);
        }
    }
}
