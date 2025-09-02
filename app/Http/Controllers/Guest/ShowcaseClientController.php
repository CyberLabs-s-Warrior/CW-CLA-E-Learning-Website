<?php
namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Showcase;

class ShowcaseClientController extends Controller
{
    public function index()
    {
        $showcases = Showcase::with('user')->latest()->paginate(12);
        return view('guest.showcase.index', compact('showcases'));
    }
}
