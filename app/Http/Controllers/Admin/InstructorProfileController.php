<?php

// app/Http/Controllers/Admin/InstructorProfileController.php
namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\InstructorProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InstructorProfileController extends Controller
{
    public function index(Request $request)
    {
        $q = InstructorProfile::with('user')
            ->when($request->filled('search'), function($query) use ($request) {
                $term = '%'.$request->search.'%';
                $query->whereHas('user', fn($u)=>$u->where('name','like',$term));
            })
            ->orderBy('sort_order')
            ->latest('updated_at')
            ->paginate(12)
            ->withQueryString();

        return view('admin.instructors.index', [
            'profiles' => $q,
        ]);
    }

    public function create()
    {
        // user ber-role instructor yang BELUM punya profil
        $instructorCandidates = User::role('instructor')
            ->whereDoesntHave('instructorProfile')
            ->orderBy('name')
            ->get(['id','name','email']);

        return view('admin.instructors.create', compact('instructorCandidates'));
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'user_id'       => ['required','integer','exists:users,id','unique:instructor_profiles,user_id'],
        'primary_skill' => ['required','string','max:100'],
        'short_bio'     => ['required','string','max:500'],
        'github_url'    => ['nullable','url','max:255'],
        'linkedin_url'  => ['nullable','url','max:255'],
        'sort_order'    => ['nullable','integer','min:0'],
        'is_published'  => ['nullable','boolean'],
        'avatar'        => ['nullable','image','mimes:jpg,jpeg,png,webp','max:1024'], // 1MB
    ]);

    // pastikan user role instructor … (punyamu sudah oke)
    $isInstructor = \App\Models\User::role('instructor')->whereKey($data['user_id'])->exists();
    if (! $isInstructor) {
        return back()->withErrors(['user_id' => 'User ini bukan instruktur.'])->withInput();
    }

    // sort_order default
    $nextOrder = (InstructorProfile::max('sort_order') ?? 0) + 1;
    $data['sort_order']   = $request->filled('sort_order') ? (int) $data['sort_order'] : $nextOrder;
    $data['is_published'] = (bool) ($data['is_published'] ?? true);

    // upload avatar (opsional)
    if ($request->hasFile('avatar')) {
        $data['avatar_path'] = $request->file('avatar')->store('instructors', 'public');
    }

    InstructorProfile::create($data);

    return to_route('admin.instruktur.index')->with('success','Profil instruktur berhasil dibuat.');
}

    public function edit(InstructorProfile $instruktur)
    {
        return view('admin.instructors.edit', [
            'profile' => $instruktur->load('user'),
        ]);
    }


public function update(Request $request, InstructorProfile $instruktur)
{
    $data = $request->validate([
        'primary_skill' => ['required','string','max:100'],
        'short_bio'     => ['required','string','max:500'],
        'github_url'    => ['nullable','url','max:255'],
        'linkedin_url'  => ['nullable','url','max:255'],
        'sort_order'    => ['nullable','integer','min:0'],
        'is_published'  => ['nullable','boolean'],
        'avatar'        => ['nullable','image','mimes:jpg,jpeg,png,webp','max:1024'],
    ]);

    if ($request->filled('sort_order')) {
        $data['sort_order'] = (int) $data['sort_order'];
    } else {
        unset($data['sort_order']);
    }

    $data['is_published'] = (bool) ($data['is_published'] ?? $instruktur->is_published);

    if ($request->hasFile('avatar')) {
        if ($instruktur->avatar_path) {
            Storage::disk('public')->delete($instruktur->avatar_path);
        }
        $data['avatar_path'] = $request->file('avatar')->store('instructors','public');
    }

    $instruktur->update($data);

    return to_route('admin.instruktur.index')->with('success','Profil instruktur berhasil diperbarui.');
}


    public function destroy(InstructorProfile $instruktur)
{
    // HAPUS file hanya jika ADA path-nya
    if (is_string($instruktur->avatar_path) && $instruktur->avatar_path !== '') {
        Storage::disk('public')->delete($instruktur->avatar_path);
    }

    $instruktur->delete();

    return to_route('admin.instruktur.index')->with('success','Profil dihapus.');
}
}
