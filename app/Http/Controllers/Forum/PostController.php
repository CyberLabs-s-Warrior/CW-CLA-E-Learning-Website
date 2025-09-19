<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\ForumPost;
use App\Models\ForumThread;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(Request $request, $threadId)
    {
        $thread = ForumThread::findOrFail($threadId);

        if ($thread->is_locked) {
            return back()->with('error','Topik terkunci. Tidak dapat membalas.');
        }

        $data = $request->validate([
            'body' => 'required|string|min:2',
        ]);

        ForumPost::create([
            'thread_id' => $thread->id,
            'user_id'   => $request->user()->id,
            'body'      => $data['body'],
        ]);

        // Update bump
        $thread->touch();

        return back()->with('success','Balasan terkirim.');
    }
}
