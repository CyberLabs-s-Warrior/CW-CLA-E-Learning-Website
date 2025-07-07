<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourseClientController extends Controller
{
    public function index()
    {
        return view('clients.course.index');
    }
}
