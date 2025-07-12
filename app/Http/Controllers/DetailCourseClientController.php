<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DetailCourseClientController extends Controller
{
    public function index()
    {
        return view('clients.detail.index');
    }
}
