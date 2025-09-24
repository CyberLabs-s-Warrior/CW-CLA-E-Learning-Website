<?php

namespace Database\Seeders;

use App\Models\ForumCategory;
use App\Models\ForumPost;
use App\Models\ForumThread;
use App\Models\ForumThreadResolution;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ForumSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        // Pastikan ada user & kategori
        if (User::count() === 0) {
            $this->call(UserSeeder::class);
        }
        if (ForumCategory::count() === 0) {
            $this->call(ForumCategorySeeder::class);
        }

        $users = User::all();
        $categories = ForumCategory::all();

        $sampleImage = public_path('image/galeri1.jpeg'); // <- pastikan file ini ada

        foreach ($categories as $cat) {
            $threadsToMake = rand(3, 6);

            for ($i = 0; $i < $threadsToMake; $i++) {
                $author = $users->random();

                // Kadang pakai gambar
                $threadImagePath = $this->maybeCopyImage($sampleImage, 'forum/threads');

                $thread = ForumThread::create([
                    'category_id' => $cat->id,
                    'user_id'     => $author->id,
                    'title'       => rtrim($faker->sentence(rand(5, 9)), '.'),
                    'body'        => $faker->paragraphs(rand(2, 4), true),
                    'image_path'  => $threadImagePath,  // nullable
                    'is_locked'   => (bool)rand(0, 10) === 0, // kecil kemungkinan terkunci
                    'pinned_at'   => rand(0, 10) === 0 ? now() : null,
                ]);

                // Balasan 1–5
                $repliesCount = rand(1, 5);
                $replyIds = [];
                for ($r = 0; $r < $repliesCount; $r++) {
                    $replier = $users->random();

                    // Hanya sebagian reply pakai gambar
                    $postImagePath = rand(0, 3) === 0
                        ? $this->maybeCopyImage($sampleImage, 'forum/posts')
                        : null;

                    $post = ForumPost::create([
                        'thread_id'  => $thread->id,
                        'user_id'    => $replier->id,
                        'body'       => $faker->paragraphs(rand(1, 3), true),
                        'image_path' => $postImagePath, // nullable
                    ]);

                    $replyIds[] = $post->id;
                }

                // 40% thread diberi jawaban terbaik acak dari reply yang ada
                if (!empty($replyIds) && rand(0, 9) < 4) {
                    $bestPostId = $faker->randomElement($replyIds);
                    ForumThreadResolution::updateOrCreate(
                        ['thread_id' => $thread->id],
                        ['post_id' => $bestPostId, 'marked_by' => $author->id]
                    );
                }

                // Biar "updated_at" naik
                $thread->touch();
            }
        }
    }

    /**
     * Copy sample image to storage disk('public') folder and return the relative path,
     * or null if sample file doesn't exist.
     */
    private function maybeCopyImage(string $sourceFile, string $destFolder): ?string
    {
        if (!file_exists($sourceFile)) {
            return null;
        }
        $ext = pathinfo($sourceFile, PATHINFO_EXTENSION) ?: 'jpg';
        $name = Str::uuid()->toString().'.'.$ext;
        $dest = trim($destFolder, '/').'/'.$name;

        // simpan binary ke storage public
        Storage::disk('public')->put($dest, file_get_contents($sourceFile));

        return $dest; // simpan ke kolom image_path
    }
}
