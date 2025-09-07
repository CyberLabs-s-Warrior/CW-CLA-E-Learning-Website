<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\InstructorProfile;

class InstrukturClientController extends Controller
{
    public function index()
    {
        $profiles = InstructorProfile::query()
            ->with(['user:id,name'])    
            ->where('is_published', true)
            ->whereHas('user')          
            ->orderBy('sort_order')
            ->orderByDesc('updated_at')
            ->get();

        return view('guest.instruktur.index', compact('profiles'));
    }
}
