<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('login.session'); // pastikan hanya user login yang bisa akses
    }

    public function dashboard()
    {
        return view('user.dashboard.index');
    }

    public function artikel()
    {
        return view('user.artikel.index');
    }

    public function riwayatPrediksi()
    {
        return view('user.riwayat-prediksi.index');
    }

    public function laporan()
    {
        return view('user.laporan.index');
    }
}