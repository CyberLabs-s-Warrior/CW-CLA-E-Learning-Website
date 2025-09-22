<?php

namespace App\Http\Controllers\Admin\Forum;

use App\Http\Controllers\Controller;
use App\Models\ForumThread;
use App\Models\ForumCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class ThreadController extends Controller
{
    public function index(Request $request)
    {
        $this->authorizeAdmin($request);

        $q           = $request->string('q')->toString();
        $categoryId  = $request->integer('category_id');
        $userId      = $request->integer('user_id');
        $status      = $request->string('status')->toString(); // pinned|locked|trashed|all
        $perPage     = $request->integer('per_page') ?: 20;

        $query = ForumThread::query()->withCount('posts')->with(['category','user']);

        if ($status === 'trashed') {
            $query->onlyTrashed();
        } elseif ($status === 'all') {
            $query->withTrashed();
        }

        if ($q) {
            $query->where(function($x) use ($q) {
                $x->where('title', 'like', "%{$q}%")
                  ->orWhere('body', 'like', "%{$q}%");
            });
        }
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        if ($userId) {
            $query->where('user_id', $userId);
        }
        if ($status === 'pinned') {
            $query->whereNotNull('pinned_at');
        }
        if ($status === 'locked') {
            $query->where('is_locked', true);
        }

        $threads = $query
            ->orderByRaw('pinned_at IS NULL')
            ->orderByDesc('pinned_at')
            ->orderByDesc('updated_at')
            ->paginate($perPage)
            ->withQueryString();

        $categories = ForumCategory::orderBy('sort_order')->get();

        return view('admin.forum.threads.index', compact('threads','categories','q','categoryId','userId','status','perPage'));
    }

    public function destroy(Request $request, $id)
    {
        $this->authorizeAdmin($request);
        $thread = ForumThread::findOrFail($id);
        $thread->delete(); // soft delete
        return back()->with('success','Thread diarsipkan (soft delete).');
    }

    public function restore(Request $request, $id)
    {
        $this->authorizeAdmin($request);
        $thread = ForumThread::onlyTrashed()->findOrFail($id);
        $thread->restore();
        return back()->with('success','Thread dipulihkan.');
    }

    public function forceDelete(Request $request, $id)
    {
        $this->authorizeAdmin($request);
        $thread = ForumThread::withTrashed()->findOrFail($id);

        if ($thread->image_path) {
            Storage::disk('public')->delete($thread->image_path);
        }
        foreach ($thread->posts()->withTrashed()->get() as $post) {
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }
        }

        $thread->forceDelete();
        return back()->with('success','Thread dihapus permanen.');
    }


    public function trashedList(Request $request)
    {
        $this->authorizeAdmin($request);

        $items = ForumThread::onlyTrashed()
            ->with(['category:id,name','user:id,name'])
            ->orderByDesc('deleted_at')
            ->limit(300)
            ->get(['id','title','deleted_at','category_id','user_id']);

        return response()->json([
            'data' => $items->map(function ($t) {
                return [
                    'id'         => $t->id,
                    'title'      => $t->title,
                    'deleted_at' => $t->deleted_at?->format('d M Y H:i'),
                    'category'   => $t->category?->name,
                    'author'     => $t->user?->name,
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

        ForumThread::onlyTrashed()->whereIn('id', $data['ids'])->restore();
        return response()->json(['ok' => true, 'message' => 'Dipulihkan.']);
    }

    public function bulkForceDelete(Request $request)
    {
        $this->authorizeAdmin($request);
        $data = $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'integer',
        ]);

        $threads = ForumThread::withTrashed()->whereIn('id', $data['ids'])->get();

        foreach ($threads as $thread) {
            if ($thread->image_path) {
                Storage::disk('public')->delete($thread->image_path);
            }
            foreach ($thread->posts()->withTrashed()->get() as $post) {
                if ($post->image_path) Storage::disk('public')->delete($post->image_path);
            }
            $thread->forceDelete();
        }

        return response()->json(['ok' => true, 'message' => 'Dihapus permanen.']);
    }

    private function authorizeAdmin(Request $request): void
    {
        if (!$request->user()?->hasAnyRole(['superadmin','admin'])) {
            abort(403);
        }
    }
}
