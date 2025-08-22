<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\UserProfile;

class PendataanClientController extends Controller
{
    public function index()
    {
        return view('student.pendataan.index');
    }

    public function store(Request $request)
    {
        if (UserProfile::where('user_id', Auth::id())->exists()) {
            return redirect()->route('dashboard.index')->with('info', 'Profil sudah ada.');
        }

        $validated = $request->validate([
            'status'     => ['required','string','max:255'],
            'tgl_lahir'  => ['required','date','before_or_equal:today'],
            'foto'       => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ], [
            'tgl_lahir.before_or_equal' => 'Tanggal lahir tidak boleh di masa depan.',
        ]);

        $data = [
            'user_id'   => Auth::id(),
            'status'    => $validated['status'],
            'tgl_lahir' => $validated['tgl_lahir'],
            'foto'      => null,
        ];

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('user_photos', 'public');
        }

        UserProfile::create($data);

        auth()->user()->load('profile');

        return redirect()->route('dashboard.index')->with('success', 'Data profil berhasil disimpan!');
    }
}
