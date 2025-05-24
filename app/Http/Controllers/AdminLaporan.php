<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminLaporan extends Controller
{
    

    public function laporan()
    {
        return view('admin.laporan.index');
    }

    
}
