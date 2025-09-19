<?php

namespace App\Http\Controllers\Admin\Forum;

use App\Http\Controllers\Controller;
use App\Models\ForumPost;
use App\Models\ForumThread;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $this->authorizeAdmin($request);

        $q        = $request->string('q')->toString();
        $threadId = $request->integer('thread_id');
        $userId   = $request->integer('user_id');
        $status   = $request->string('status')->toString(); // trashed|all
        $perPage  = $request->integer('per_page') ?: 20;

        $query = ForumPost::query()->with(['thread','user']);

        if ($status === 'trashed') {
            $query->onlyTrashed();
        } elseif ($status === 'all') {
            $query->withTrashed();
        }

        if ($q) {
            $query->where('body', 'like', "%{$q}%");
        }
        if ($threadId) {
            $query->where('thread_id', $threadId);
        }
        if ($userId) {
            $query->where('user_id', $userId);
        }

        $posts = $query->orderByDesc('created_at')
                       ->paginate($perPage)
                       ->withQueryString();

        // opsional: dropdown cepat untuk memilih thread
        $recentThreads = ForumThread::orderByDesc('updated_at')->limit(30)->get();

        return view('admin.forum.posts.index', compact('posts','recentThreads','q','threadId','userId','status','perPage'));
    }

    public function destroy(Request $request, $id)
    {
        $this->authorizeAdmin($request);
        $post = ForumPost::findOrFail($id);
        $post->delete(); // soft delete
        return back()->with('success','Post diarsipkan (soft delete).');
    }

    public function restore(Request $request, $id)
    {
        $this->authorizeAdmin($request);
        $post = ForumPost::onlyTrashed()->findOrFail($id);
        $post->restore();
        return back()->with('success','Post dipulihkan.');
    }

    public function forceDelete(Request $request, $id)
    {
        $this->authorizeAdmin($request);
        $post = ForumPost::withTrashed()->findOrFail($id);
        $post->forceDelete();
        return back()->with('success','Post dihapus permanen.');
    }

    private function authorizeAdmin(Request $request): void
    {
        if (!$request->user()?->hasAnyRole(['superadmin','admin'])) {
            abort(403);
        }
    }
}
