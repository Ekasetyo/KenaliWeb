<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Deteksi;

class DeteksiController extends Controller
{
    public function store(Request $request)
    {
        // Validasi (optional, tapi disarankan)
        $validated = $request->validate([
            'user_id' => 'required|string',
            'hasil' => 'required|string',
            'confidence' => 'required|numeric',
            'timestamp' => 'required|date',
        ]);

        // Simpan ke MongoDB
        $deteksi = Deteksi::create($validated);

        return response()->json([
            'message' => 'Data berhasil disimpan',
            'data' => $deteksi
        ], 201);
    }
}
