<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutClientController extends Controller
{
    public function index()
    {
        return view('clients.about.index');
    }
}
