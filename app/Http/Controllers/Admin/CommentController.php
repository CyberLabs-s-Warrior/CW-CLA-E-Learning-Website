<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\DetailCourse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with('detailCourse')->latest()->get();
        return view('admin.comments.index', compact('comments'));
    }

    public function create()
    {
        $courses = DetailCourse::all();
        return view('admin.comments.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'detail_courses_id' => 'required|exists:detail_courses,id',
            'name' => 'required|string|max:100',
            'content' => 'required|string',
        ]);

        Comment::create($request->only('detail_courses_id', 'name', 'content'));

        return redirect()->route('admin.comments.index')->with('success', 'Komentar berhasil ditambahkan.');
    }

    public function show(Comment $comment)
    {
        return view('admin.comments.show', compact('comment'));
    }

    public function edit(Comment $comment)
    {
        $courses = DetailCourse::all();
        return view('admin.comments.edit', compact('comment', 'courses'));
    }

    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'detail_courses_id' => 'required|exists:detail_courses,id',
            'name' => 'required|string|max:100',
            'content' => 'required|string',
        ]);

        $comment->update($request->only('detail_courses_id', 'name', 'content'));

        return redirect()->route('admin.comments.index')->with('success', 'Komentar berhasil diperbarui.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->route('admin.comments.index')->with('success', 'Komentar berhasil dihapus.');
    }
}
