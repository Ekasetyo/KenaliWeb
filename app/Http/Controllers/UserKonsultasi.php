<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Konsultasi;
use App\Models\PesanKonsultasi;;
use Illuminate\Support\Facades\Auth;

class UserKonsultasi extends Controller
{
    public function index()
    {
        $userId = session('user')->id; // Atau gunakan Auth::id() jika pakai Auth
        $consultations = Konsultasi::where('user_id', $userId)->latest()->get();

        return view('laporan.konsultasi', compact('konsultasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'topic' => 'required|string|max:255',
            'pesan' => 'required|string',
        ]);

        $consultation = Konsultasi::create([
            'user_id' => session('user')->id,
            'topic' => $request->topic,
            'status' => 'active',
        ]);

        PesanKonsultasi::create([
            'konsultasi_id' => $konsultasi->id,
            'sender' => 'user',
            'pesan' => $request->pesan,
        ]);

        return redirect()->back()->with('success', 'Konsultasi berhasil dikirim.');
    }

    public function reply(Request $request)
    {
        $request->validate([
            'konsultasi_id' => 'required|exists:konsultasi,id',
            'pesan' => 'required|string',
        ]);

        PesanKonsultasi::create([
            'konsultasi_id' => $request->konsultasi_id,
            'sender' => 'user',
            'pesan' => $request->pesan,
        ]);

        return redirect()->back()->with('success', 'Pesan berhasil dikirim.');
    }
}
