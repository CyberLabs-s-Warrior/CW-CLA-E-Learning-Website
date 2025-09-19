<?php

namespace App\Http\Controllers\Forum\Moderator;

use App\Http\Controllers\Controller;
use App\Models\ForumThread;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ThreadModerationController extends Controller
{
    public function pin(Request $request, $id)
    {
        $this->authorizeRoles($request);
        $thread = ForumThread::findOrFail($id);
        $thread->update(['pinned_at' => Carbon::now()]);
        return back()->with('success','Topik dipin.');
    }

    public function unpin(Request $request, $id)
    {
        $this->authorizeRoles($request);
        $thread = ForumThread::findOrFail($id);
        $thread->update(['pinned_at' => null]);
        return back()->with('success','Pin dihapus.');
    }

    public function lock(Request $request, $id)
    {
        $this->authorizeRoles($request);
        $thread = ForumThread::findOrFail($id);
        $thread->update(['is_locked' => true]);
        return back()->with('success','Topik dikunci.');
    }

    public function unlock(Request $request, $id)
    {
        $this->authorizeRoles($request);
        $thread = ForumThread::findOrFail($id);
        $thread->update(['is_locked' => false]);
        return back()->with('success','Topik dibuka.');
    }

    private function authorizeRoles(Request $request): void
    {
        if (!$request->user()->hasAnyRole(['superadmin','admin','instructor'])) {
            abort(403);
        }
    }
}
