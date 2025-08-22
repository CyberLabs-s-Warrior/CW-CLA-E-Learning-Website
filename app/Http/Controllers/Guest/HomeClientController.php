<?php

namespace App\Http\Controllers\Guest;
use App\Http\Controllers\Controller; // <- penting

use Illuminate\Http\Request;

class HomeClientController extends Controller
{
    public function index()
    {
        return view('guest.home.index');
    }
}
