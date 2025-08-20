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
        return view('clients.login.index');
    }

    public function register(Request $request)
{
    // 1) Validasi input
    $data = $request->validate([
        'name'                  => ['required','string','max:100'],         
        'username'              => ['required','string','min:3','max:30','alpha_dash','unique:users,username'],
        'email'                 => ['required','email','max:255','unique:users,email'],
        'phone'                 => ['required','string','max:20','unique:users,phone'],          // tambah 'unique:users,phone' kalau ingin unik
        'password'              => ['required','confirmed','min:6'],
     ]);

     
    $normalizedPhone = preg_replace('/(?!^\+)[^\d]/', '', $data['phone']);   
    $normalizedPhone = preg_replace('/\s+/', '', $normalizedPhone);

    // 3) Buat user
    $user = \App\Models\User::create([
        'name'     => $data['name'],
        'username' => $data['username'],
        'email'    => $data['email'],
        'phone'    => $normalizedPhone,
        'password' => \Illuminate\Support\Facades\Hash::make($data['password']),
    ]);



    if (method_exists($user, 'assignRole')) {
        $user->assignRole('student');
    }
    event(new \Illuminate\Auth\Events\Registered($user));

    \Illuminate\Support\Facades\Auth::login($user);
    $request->session()->regenerate();

    return redirect()
        ->route('verification.notice')
        ->with('status', 'We sent a verification link to your email. Please verify to continue.');
}


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (! $request->user()->hasVerifiedEmail()) {
                return redirect()->route('verification.notice');
            }

            if (! $request->user()->hasRole('student')) {
                Auth::logout();
                return back()->withErrors(['email' => 'Unauthorized.'])->onlyInput('email');
            }

            return redirect()->route('dashboard.index')->with('status', 'Login successful. Welcome back!');
        }

        return back()
            ->withErrors(['email' => 'The provided credentials do not match our records.'])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'You have been logged out successfully.');
    }
}
