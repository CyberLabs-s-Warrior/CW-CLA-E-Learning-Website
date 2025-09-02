<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Showcase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShowcaseController extends Controller
{
    /**
     * List showcase (admin)
     */
    public function index()
    {
        $showcases = Showcase::with('user')->latest()->paginate(10);
        // pastikan view admin.showcase.index memakai $showcases
        return view('admin.showcase.index', compact('showcases'));
    }

    /**
     * Form create
     */
    public function create()
    {
        // Pakai Spatie:
        $students = User::role('student')->get();

        return view('admin.showcase.create', compact('students'));
    }

    /**
     * Simpan data baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'     => ['required', 'exists:users,id'],
            'title'       => ['required', 'string', 'max:150'],
            'description' => ['required', 'string'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('showcases', 'public');
        }

        Showcase::create($validated);

        return redirect()
            ->route('admin.showcases.index')
            ->with('success', 'Karya berhasil ditambahkan!');
    }

    /**
     * Form edit
     */
    public function edit(Showcase $showcase)
    {
        $students = User::role('student')->get();

        // NOTE: kirim $showcase (bukan $project)
        return view('admin.showcase.edit', compact('showcase', 'students'));
    }

    /**
     * Update data
     */
    public function update(Request $request, Showcase $showcase)
    {
        $validated = $request->validate([
            'user_id'     => ['required', 'exists:users,id'],
            'title'       => ['required', 'string', 'max:150'],
            'description' => ['required', 'string'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            if ($showcase->image_path) {
                Storage::disk('public')->delete($showcase->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('showcases', 'public');
        }

        $showcase->update($validated);

        return redirect()
            ->route('admin.showcases.index')
            ->with('success', 'Karya berhasil diperbarui!');
    }

    /**
     * Hapus
     */
    public function destroy(Showcase $showcase)
    {
        if ($showcase->image_path) {
            Storage::disk('public')->delete($showcase->image_path);
        }

        $showcase->delete();

        return back()->with('success', 'Karya berhasil dihapus!');
    }
}
