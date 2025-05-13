<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
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
