<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDataPrediksi extends Controller
{
    

    public function dataPrediksi()
    {
        return view('admin.hasil-prediksi.index');
    }

    
}
