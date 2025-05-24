<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Konsultasi;
use App\Models\PesanKonsultasi;

class AdminKonsultasi extends Controller
{
    public function index()
    {

        $konsultasi = Konsultasi::latest()->get();
        $consultations = Konsultasi::latest()->get();

        return view('admin.konsultasi.index', compact('konsultasi'));
    }

    public function show($id)
    {
        $konsultasi = Konsultasi::findOrFail($id);
        $pesan = PesanKonsultasi::where('konsultasi_id', $id)->get();
        $messages = PesanKonsultasi::where('konsultasi_id', $id)->get();

        return response()->json([
            'konsultasi' => $konsultasi,
            'pesan' => $pesan,
        ]);
    }

    public function reply(Request $request)
    {
        $request->validate([

            'konsultasi_id' => 'required|exists:konsultasis,id',
            'konsultasi_id' => 'required|exists:konsultasi,id',
            'pesan' => 'required|string',
        ]);

        PesanKonsultasi::create([
            'konsultasi_id' => $request->konsultasi_id,
            'sender' => 'admin',
            'pesan' => $request->pesan,
            'pesan' => $request->message,
        ]);

        return response()->json(['success' => true]);
    }

    public function close($id)
    {
        $konsultasi = Konsultasi::findOrFail($id);
        $konsultasi->status = 'completed';
        $konsultasi->save();

        return response()->json(['success' => true]);
    }
}
