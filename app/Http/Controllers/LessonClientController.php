<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LessonClientController extends Controller
{
    public function index()
    {
        return view('clients.lesson.index');
    }
}
