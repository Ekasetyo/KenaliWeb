<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Konsultasi;
use Illuminate\Support\Facades\Session;
use MongoDB\BSON\ObjectId;

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
            return redirect()->back()->with('error', 'ID pengguna tidak valid.');
        }

        $request->validate([
            'identitas' => 'required|string|max:255',
            'keluhan' => 'required|string',
        ], [
            'identitas.required' => 'Identitas wajib diisi.',
            'identitas.max' => 'Identitas maksimal 255 karakter.',
            'keluhan.required' => 'Keluhan wajib diisi.',
        ]);

        Konsultasi::create([
            'id_pengguna' => $id_pengguna,
            'identitas' => $request->identitas,
            'keluhan' => $request->keluhan,
            'jawaban' => null,
            'nama_pemberi_jawaban' => null,
        ]);
