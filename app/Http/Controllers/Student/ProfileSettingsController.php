<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;  


class ProfileSettingsController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user()->load('profile');

        // Safety double-check (walau sudah difilter middleware)
        if ($user->hasRole('student') && !$user->profile) {
            return redirect()->route('pendataan.index');
        }

        // Placeholder ringkasan (bisa kamu isi nanti)
        $recentPayments = [];
        $recentLearning = [];

        return view('student.profile.index', compact('user','recentPayments','recentLearning'));
    }

    public function updateBiodata(Request $request)
    {
        $user = $request->user();
        $profile = $user->profile;

        if (!$profile) return redirect()->route('pendataan.index');

        $data = $request->validate([
            'jenis_kelamin' => ['required','in:Laki-laki,Perempuan'],
            'tgl_lahir'     => ['nullable','date','before_or_equal:today'],
            'status'        => ['nullable','string','max:255'],
            'foto'          => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ], [
            'tgl_lahir.before_or_equal' => 'Tanggal lahir tidak boleh di masa depan.',
        ]);

        if ($request->hasFile('foto')) {
            if ($profile->foto) Storage::disk('public')->delete($profile->foto);
            $data['foto'] = $request->file('foto')->store('user_photos', 'public');
        }

        $profile->update($data);

        return back()->with('success','Biodata berhasil diperbarui.');
    }

    public function updateAccount(Request $request)
{
    $user = $request->user();

    // Melarang perubahan email (kalau user nyelipin field email di payload => 422)
    $data = $request->validate([
        'name'     => ['required','string','max:255'],
        'username' => ['nullable','string','max:255', Rule::unique('users','username')->ignore($user->id)],
        'phone'    => ['nullable','string','max:255'],
        'email'    => ['prohibited'], // ⬅️ ini penting: melarang field email muncul
    ]);

    // Update hanya field yang diizinkan
    $user->update(Arr::only($data, ['name','username','phone']));

    return back()->with('success','Akun berhasil diperbarui.');
}
}