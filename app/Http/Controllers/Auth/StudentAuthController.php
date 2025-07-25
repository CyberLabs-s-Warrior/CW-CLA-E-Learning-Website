<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class StudentAuthController extends Controller
{
     public function showLoginRegisterForm()
     {
        return view('clients.login.index');
     }

     public function register(Request $request)
     {
        $request->validate([
            'name' => 'required|string|max:100',
            'email'=> 'required|email|unique:users,email',
            'password'=> 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('student');
        
        Auth::login($user);
        return redirect()->route('home.index')->with('status', 'Registration successful. Welcome!');
     }

     public function login (Request $request)
     {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if($user->hasRole('student')) {
                $request->session()->regenerate();
                return redirect()->route('home.index')->with('status', 'Login successful. Welcome back!');
            } else {
                Auth::logout();
                return back()->withErrors(['email' => 'Only students can login from here']);
            }
            
        }
        return back()->withErrors(['email'=> 'The provided credentials do not match our records.']);

     }

     public function logout(Request $request)
     {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home.index')->with('status', 'You have been logged out successfully.');
     }
}
