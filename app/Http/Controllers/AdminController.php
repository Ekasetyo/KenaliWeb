<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // public function dashboard()
    // {
    // return view('admin.dashboard.index');
    // }

    public function __construct()
    {
        $this->middleware(['auth', 'admin']); // hanya admin yang bisa akses
    }
    
}