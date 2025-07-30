<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileClientController extends Controller
{
    public function index()
    {
        return view('clients.profile.index');
        $user = Auth::user();   
        return view('clients.profile.index', compact('user'));
    }
}
