<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;  

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileClientController extends Controller
{
    public function index()
    {
        $user = Auth::user();   

        if($user->hasRole('student') && !$user->profile){
            return redirect()->route('pendataan.index');
        }
        return view('student.dashboard.index', compact('user'));
    }
}
