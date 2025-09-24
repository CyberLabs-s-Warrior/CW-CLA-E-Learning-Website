<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\About;

class AboutClientController extends Controller
{
    public function index()
    {
        // Urutkan pakai display_order kalau ada; fallback ke created_at
        $contents = About::query()
            ->orderByRaw('COALESCE(display_order, 999999) ASC')
            ->orderBy('created_at', 'asc')
            ->get()
            ->groupBy('section'); // hasil: ['visi'=>[...], 'misi'=>[...], 'sejarah'=>[...], ...]

        return view('guest.about.index', compact('contents'));
    }
}
