<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Http\Request;

class TestimoniController extends Controller
{
    public function index()
    {
        $items = Testimonial::with('user:id,name')->latest()->paginate(12);

        return view('admin.testimoni.index', compact('items'));
    }

    public function create()
    {
        // Ambil hanya user dengan role student
        $students = User::role('student')
            ->select('id','name')
            ->orderBy('name')
            ->get();

        return view('admin.testimoni.create', compact('students'));
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'user_id'      => ['required','exists:users,id','unique:testimonials,user_id'],
        'content'      => ['required','string','min:8','max:1000'],
        'is_published' => ['nullable','boolean'],
    ]);

    // benar: 0/1 dari form → boolean
    $data['is_published'] = $request->boolean('is_published');

    Testimonial::create($data);

    return redirect()->route('admin.testimoni.index')
        ->with('success', 'Testimoni berhasil dibuat.');
}


    public function edit(Testimonial $testimoni)
    {
        $students = User::role('student')
            ->select('id','name')
            ->orderBy('name')
            ->get();

        return view('admin.testimoni.edit', compact('testimoni','students'));
    }

    public function update(Request $request, Testimonial $testimoni)
{
    $data = $request->validate([
        'user_id'      => ['required','exists:users,id','unique:testimonials,user_id,'.$testimoni->id],
        'content'      => ['required','string','min:8','max:1000'],
        'is_published' => ['nullable','boolean'],
    ]);

    $data['is_published'] = $request->boolean('is_published'); // <- tanpa default

    $testimoni->update($data);

    return redirect()->route('admin.testimoni.index')
        ->with('success', 'Testimoni diperbarui.');
}


    public function destroy(Testimonial $testimoni)
    {
        $testimoni->delete();

        return redirect()->route('admin.testimoni.index')
            ->with('success', 'Testimoni dihapus.');
    }
}
