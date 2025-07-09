<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileClientController extends Controller
{
    public function index()
    {
        return view('clients.profile.index');
    }
}
