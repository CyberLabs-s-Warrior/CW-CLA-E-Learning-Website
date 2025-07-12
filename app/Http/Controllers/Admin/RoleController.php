<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Tampilkan halaman daftar role.
     */
    public function index()
    {
        return view('admin.role.index');
    }
}
