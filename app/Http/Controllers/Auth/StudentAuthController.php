<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentAuthController extends Controller
{
    public function showLoginRegisterForm()
    {
        // Blade-mu: resources/views/guest/login/index.blade.php
        return view('guest.login.index');
    }

    public function register(Request $request)
    {
        // Validasi
        $data = $request->validate([
            'name'                  => ['required','string','max:100'],
            'username'              => ['required','string','min:3','max:30','alpha_dash','unique:users,username'],
            'email'                 => ['required','email','max:255','unique:users,email'],
            'phone'                 => ['required','string','max:20','unique:users,phone'],
            'password'              => ['required','confirmed','min:6'],
        ]);

        // Normalisasi phone
        $normalizedPhone = preg_replace('/(?!^\+)[^\d]/', '', $data['phone']);
        $normalizedPhone = preg_replace('/\s+/', '', $normalizedPhone);

        // Buat user
        $user = User::create([
            'name'     => $data['name'],
            'username' => $data['username'],
            'email'    => $data['email'],
            'phone'    => $normalizedPhone,
            'password' => Hash::make($data['password']),
        ]);

        if (method_exists($user, 'assignRole')) {
            $user->assignRole('student');
        }

        event(new Registered($user)); // untuk email verification

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()
            ->route('verification.notice')
            ->with('status', 'We sent a verification link to your email. Please verify to continue.');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => ['required','email'],
            'password' => ['required'],
        ]);

        $studentUser = User::query()
            ->where('email', $data['email'])
            ->whereHas('roles', fn($q) => $q->where('name', 'student'))
            ->first();

        if (! $studentUser) {
            return back()
                ->withErrors(['email' => 'Akun ini tidak memiliki akses.'])
                ->onlyInput('email');
        }

        if (! Auth::attempt(['email' => $data['email'], 'password' => $data['password']], $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        if (! $request->user()->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        return redirect()->route('dashboard.index')->with('status', 'Login successful. Welcome back!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Kembali ke halaman login student
        return redirect()->route('login')->with('status', 'You have been logged out successfully.');
    }
}
