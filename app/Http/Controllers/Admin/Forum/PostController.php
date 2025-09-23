<?php

namespace App\Http\Controllers\Admin\Forum;

use App\Http\Controllers\Controller;
use App\Models\ForumPost;
use App\Models\ForumThread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;

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

        if ($q)        $query->where('body', 'like', "%{$q}%");
        if ($threadId) $query->where('thread_id', $threadId);
        if ($userId)   $query->where('user_id', $userId);

        $posts = $query->orderByDesc('created_at')
                       ->paginate($perPage)
                       ->withQueryString();

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

        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        $post->forceDelete();
        return back()->with('success','Post dihapus permanen.');
    }

    // ======== Tambahan untuk modal “Tong Sampah” + Bulk ========

    public function trashedList(Request $request)
    {
        $this->authorizeAdmin($request);

        $items = ForumPost::onlyTrashed()
            ->with(['thread:id,title','user:id,name'])
            ->orderByDesc('deleted_at')
            ->limit(400)
            ->get(['id','thread_id','user_id','deleted_at','body']);

        return response()->json([
            'data' => $items->map(function ($p) {
                return [
                    'id'         => $p->id,
                    'thread'     => $p->thread?->title,
                    'author'     => $p->user?->name,
                    'excerpt'    => str()->limit(strip_tags($p->body), 80),
                    'deleted_at' => $p->deleted_at?->format('d M Y H:i'),
                ];
            }),
        ]);
    }

    public function bulkRestore(Request $request)
    {
        $this->authorizeAdmin($request);
        $data = $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'integer',
        ]);

        ForumPost::onlyTrashed()->whereIn('id', $data['ids'])->restore();
        return response()->json(['ok' => true, 'message' => 'Dipulihkan.']);
    }

     public function bulkForceDelete(Request $request)
    {
        $this->authorizeAdmin($request);

        $data = $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'integer',
        ]);

        DB::transaction(function () use ($data) {
            $posts = ForumPost::withTrashed()->whereIn('id', $data['ids'])->get();

            foreach ($posts as $post) {
                if ($post->image_path) {
                    Storage::disk('public')->delete($post->image_path);
                }
                // TODO (opsional): detach likes/votes/attachments lain di sini kalau ada relasi lain
                $post->forceDelete();
            }
        });

        return response()->json(['ok' => true, 'message' => 'Dihapus permanen.']);
    }

    private function authorizeAdmin(Request $request): void
    {
        if (!$request->user()?->hasAnyRole(['superadmin','admin'])) {
            abort(403);
        }
    }
}
