<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\About; 

class AboutClientController extends Controller
{
    public function index()
    {
        $visi = About::where('section', 'visi')->first();
        $misi = About::where('section', 'misi')->first();
        return view('clients.about.index' , compact('visi', 'misi'));
    }
}
