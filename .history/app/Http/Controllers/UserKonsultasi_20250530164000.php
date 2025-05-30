<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Konsultasi;
use Illuminate\Support\Facades\Session;
use MongoDB\BSON\ObjectId;
use Illuminate\Support\Facades\Log;

class UserKonsultasi extends Controller
{
    public function index()
    {
        $user = Session::get('user');
        if (!$user) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $id_pengguna = $user['id'];
        try {
            $id_pengguna = new ObjectId($id_pengguna);
        } catch (\Exception $e) {
            Log::error('Invalid user ID in index: ' . $e->getMessage());
            return redirect()->back()->with('error', 'ID pengguna tidak valid.');
        }

        $daftar_konsultasi = Konsultasi::where('id_pengguna', $id_pengguna)->with('pengguna')->latest()->get();
        return view('user.konsultasi.index', compact('daftar_konsultasi'));
    }

    public function create()
    {
        $user = Session::get('user');
        if (!$user) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        return view('user.konsultasi.create');
    }

    public function store(Request $request)
    {
        $user = Session::get('user');
        if (!$user) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $id_pengguna = $user['id'];
        try {
            $id_pengguna = new ObjectId($id_pengguna);
        } catch (\Exception $e) {
            Log::error('Invalid user ID in store: ' . $e->getMessage());
            return redirect()->back()->with('error', 'ID pengguna tidak valid.');
        }

        Konsultasi::create([
            'id_pengguna' => $id_pengguna,
            'identitas' => $request->identitas,
            'keluhan' => $request->keluhan,
            'jawaban' => null,
            'nama_pemberi_jawaban' => null,
        ]);

        return redirect()->route('konsultasi.index')->with('success', 'Konsultasi berhasil dikirim.');
    }

    public function show($id)
{
    $user = Session::get('user');
    if (!$user) {
        return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
    }

    $id_pengguna = $user['id'];
    try {
        $id_pengguna = new ObjectId($id_pengguna);
        $id = new ObjectId($id);
    } catch (\Exception $e) {
        Log::error('Invalid ID in show: ' . $e->getMessage());
        return redirect()->back()->with('error', 'ID tidak valid.');
    }

    $konsultasi = Konsultasi::where('_id', $id)->where('id_pengguna', $id_pengguna)->with('pengguna')->firstOrFail();
    Log::info('Detail konsultasi untuk user:', [
        'id_konsultasi' => (string)$id,
        'id_pengguna' => (string)$id_pengguna,
        'nama_pengguna_relasi' => $konsultasi->pengguna->name ?? 'Tidak ada',
        'nama_sesi_user' => $user['name']
    ]);
    return view('user.konsultasi.detail', compact('konsultasi'));
}

    public function destroy($id)
    {
        $user = Session::get('user');
        if (!$user) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $id_pengguna = $user['id'];
        try {
            $id_pengguna = new ObjectId($id_pengguna);
            $id = new ObjectId($id);
        } catch (\Exception $e) {
            Log::error('Invalid ID in destroy: ' . $e->getMessage());
            return redirect()->back()->with('error', 'ID tidak valid.');
        }

        $konsultasi = Konsultasi::where('_id', $id)->where('id_pengguna', $id_pengguna)->firstOrFail();
        
        if ($konsultasi->jawaban) {
            return redirect()->back()->with('error', 'Konsultasi yang sudah dibalas tidak dapat dihapus.');
        }

        $konsultasi->delete();
        return redirect()->route('konsultasi.index')->with('success', 'Konsultasi berhasil dibatalkan.');
    }
}