<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\ForumCategory;
use App\Models\ForumThread;
use App\Models\ForumThreadResolution;
use App\Models\ForumPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ThreadController extends Controller
{
    public function create()
    {
        $categories = ForumCategory::orderBy('sort_order')->get();
        return view('forum.thread.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:forum_categories,id',
            'title'       => 'required|string|min:5|max:140',
            'body'        => 'required|string|min:10',
        ]);

        $thread = ForumThread::create([
            'category_id' => $data['category_id'],
            'user_id'     => $request->user()->id,
            'title'       => $data['title'],
            'body'        => $data['body'],
        ]);

        return redirect()->route('forum.thread.show', [
            'id' => $thread->id,
            'slug' => Str::slug($thread->title),
        ])->with('success','Topik berhasil dibuat.');
    }

    public function show($id, $slug = null)
    {
        $thread = ForumThread::with([
            'category','user',
            'posts.user',
            'bestAnswer.post.user'
        ])->findOrFail($id);

        $posts = $thread->posts()->with('user')->orderBy('created_at')->paginate(15);

        return view('forum.thread.show', compact('thread','posts'));
    }

    // (Opsional) tandai jawaban terbaik
    public function resolve(Request $request, $id, $postId)
    {
        $thread = ForumThread::findOrFail($id);

        // hanya OP atau mentor/admin
        if ($request->user()->id !== $thread->user_id && !$request->user()->hasAnyRole(['superadmin','admin','instructor'])) {
            abort(403);
        }

        ForumThreadResolution::updateOrCreate(
            ['thread_id' => $thread->id],
            ['post_id' => $postId, 'marked_by' => $request->user()->id]
        );

        return back()->with('success','Jawaban terbaik ditandai.');
    }
}
