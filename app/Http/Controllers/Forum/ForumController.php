<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\ForumCategory;
use App\Models\ForumThread;

class ForumController extends Controller
{
    public function index()
    {
        $categories = ForumCategory::orderBy('sort_order')->get();

        // Ambil 10 thread terbaru (pinned di atas)
        $threads = ForumThread::with(['category','user'])
            ->orderByRaw('pinned_at IS NULL') // pinned_at NOT NULL duluan
            ->orderByDesc('pinned_at')
            ->orderByDesc('updated_at')
            ->limit(10)
            ->get();

        return view('forum.index', compact('categories','threads'));
    }

    public function category($slug)
    {
        $category = ForumCategory::where('slug',$slug)->firstOrFail();

        $threads = $category->threads()
            ->with(['user'])
            ->orderByRaw('pinned_at IS NULL')
            ->orderByDesc('pinned_at')
            ->orderByDesc('updated_at')
            ->paginate(15);

        return view('forum.category', compact('category','threads'));
    }
}
