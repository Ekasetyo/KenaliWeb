<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Konsultasi;
use Illuminate\Support\Facades\Session;
use MongoDB\BSON\ObjectId;
use RealRashid\SweetAlert\Facades\Alert;

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
            return redirect()->back()->with('error', 'ID pengguna tidak valid.');
        }

        $daftar_konsultasi = Konsultasi::where('id_pengguna', $id_pengguna)->with('pengguna')->latest()->get();
        return view('user.konsultasi.index', compact('daftar_konsultasi'));
    }

    public function create()
    {
        if (!Session::has('user')) {
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

        $request->validate([
            'identitas' => 'required|string',
            'keluhan' => 'required|string',
        ], [
            'identitas.required' => 'Identitas wajib diisi.',
            'keluhan.required' => 'Keluhan wajib diisi.',
        ]);

        try {
            $id_pengguna = new ObjectId($user['id']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'ID pengguna tidak valid.');
        }

        Konsultasi::create([
            'id_pengguna' => $id_pengguna,
            'identitas' => $request->identitas,
            'keluhan' => $request->keluhan,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('konsultasi.index')->with('success', 'Konsultasi berhasil dikirim.');
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
            return redirect()->back()->with('error', 'ID tidak valid.');
        }

        $konsultasi = Konsultasi::where('_id', $id)->where('id_pengguna', $id_pengguna)->firstOrFail();

        // Hanya izinkan hapus jika belum dijawab
        if ($konsultasi->jawaban) {
            return redirect()->back()->with('error', 'Konsultasi yang sudah dijawab tidak dapat dihapus.');
        }

        $konsultasi->delete();
        return redirect()->route('konsultasi.index')->with('success', 'Konsultasi berhasil dibatalkan.');
    }
}