<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard.index');
    }

    // public function dataUser()
    // {
    //     return view('admin.user.index');
    // }

    public function dataArtikel()
    {
        return view('admin.artikel.index');
    }

    public function dataSaran()
    {
        return view('admin.saran.index');
    }

    public function dataPrediksi()
    {
        return view('admin.hasil-prediksi.index');
    }

    public function visualisasi()
    {
        return view('admin.visualisasi.index');
    }

    public function laporan()
    {
        return view('admin.laporan.index');
    }
}
