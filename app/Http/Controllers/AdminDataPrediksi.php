<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB; // Import ini diperlukan
use Illuminate\Http\Request;

class AdminDataPrediksi extends Controller
{
    public function dataPrediksi(Request $request)
{
    $search = $request->input('search');
    
    $query = DB::connection('mongodb')
            ->table('hasil_deteksi')
            ->select([
                'user_id',
                'age',
                'prediction', 
                'created_at'
            ]);
    
    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('user_id', 'like', "%$search%")
              ->orWhere('prediction', 'like', "%$search%");
        });
    }
    
    $data = $query->orderBy('created_at', 'desc')
                 ->paginate(10);

    return view('admin.hasil-prediksi.index', compact('data'));
}
}