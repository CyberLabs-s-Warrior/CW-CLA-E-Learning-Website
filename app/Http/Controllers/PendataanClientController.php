<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;

class PendataanClientController extends Controller
{
    public function index()
    {
        return view('clients.pendataan.index');
    }

    public function store(Request $request)
{
    if (UserProfile::where('user_id', Auth::id())->exists()) {
        return redirect()->route('dashboard.index')->with('info', 'Profil sudah ada.');
    }

    $request->validate([
        'nama_lengkap' => 'required|string|max:255',
        'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        'no_hp' => 'required|string|max:20',
        'alamat' => 'required|string',
        'status' => 'required|string',
        'tgl_lahir' => 'required|date',
        'foto' => 'nullable|image|max:2048',
    ]);

    $data = $request->only(['nama_lengkap', 'jenis_kelamin', 'no_hp', 'alamat', 'status', 'tgl_lahir']);
    $data['user_id'] = Auth::id();

    if ($request->hasFile('foto')) {
        $data['foto'] = $request->file('foto')->store('foto_profil', 'public');
    }

    UserProfile::create($data);

    auth()->user()->load('profile');

    return redirect()->route('dashboard.index')->with('success', 'Data profil berhasil disimpan!');
}

}
