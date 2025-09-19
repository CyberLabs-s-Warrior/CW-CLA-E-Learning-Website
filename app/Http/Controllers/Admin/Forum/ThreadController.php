<?php

namespace App\Http\Controllers\Admin\Forum;

use App\Http\Controllers\Controller;
use App\Models\ForumThread;
use App\Models\ForumCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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

        $query = ForumThread::query()->with(['category','user']);

        // status filter
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

        // urutan: pinned dulu, lalu terbaru update
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
        $thread->forceDelete();
        return back()->with('success','Thread dihapus permanen.');
    }

    public function move(Request $request, $id)
    {
        $this->authorizeAdmin($request);
        $data = $request->validate([
            'category_id' => 'required|exists:forum_categories,id',
        ]);

        $thread = ForumThread::withTrashed()->findOrFail($id);
        $thread->update(['category_id' => $data['category_id']]);

        return back()->with('success','Thread dipindahkan ke kategori baru.');
    }

    public function pin(Request $request, $id)
    {
        $this->authorizeAdmin($request);
        $thread = ForumThread::withTrashed()->findOrFail($id);
        $thread->update(['pinned_at' => Carbon::now()]);
        return back()->with('success','Thread di-pin.');
    }

    public function unpin(Request $request, $id)
    {
        $this->authorizeAdmin($request);
        $thread = ForumThread::withTrashed()->findOrFail($id);
        $thread->update(['pinned_at' => null]);
        return back()->with('success','Pin dihapus.');
    }

    public function lock(Request $request, $id)
    {
        $this->authorizeAdmin($request);
        $thread = ForumThread::withTrashed()->findOrFail($id);
        $thread->update(['is_locked' => true]);
        return back()->with('success','Thread dikunci.');
    }

    public function unlock(Request $request, $id)
    {
        $this->authorizeAdmin($request);
        $thread = ForumThread::withTrashed()->findOrFail($id);
        $thread->update(['is_locked' => false]);
        return back()->with('success','Thread dibuka.');
    }

    private function authorizeAdmin(Request $request): void
    {
        if (!$request->user()?->hasAnyRole(['superadmin','admin'])) {
            abort(403);
        }
    }
}
