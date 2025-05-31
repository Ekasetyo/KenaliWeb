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

        return redirect()->back()->with('success', 'Konsultasi berhasil dikirim.');
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
            return redirect()->back()->with('error', 'ID tidak valid.');
        }

        $konsultasi = Konsultasi::where('_id', $id)->where('id_pengguna', $id_pengguna)->with('pengguna')->firstOrFail();
        return view('user.konsultasi.detail', compact('konsultasi'));
    }

    public function edit($id)
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
        return view('user.konsultasi.edit', compact('konsultasi'));
    }

    public function update(Request $request, $id)
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

        $request->validate([
            'identitas' => 'required|string|max:255',
            'keluhan' => 'required|string',
        ], [
            'identitas.required' => 'Identitas wajib diisi.',
            'identitas.max' => 'Identitas maksimal 255 karakter.',
            'keluhan.required' => 'Keluhan wajib diisi.',
        ]);

        $konsultasi = Konsultasi::where('_id', $id)->where('id_pengguna', $id_pengguna)->firstOrFail();
        $konsultasi->update([
            'identitas' => $request->identitas,
            'keluhan' => $request->keluhan,
        ]);

        return redirect()->route('konsultasi.show', $id)->with('success', 'Konsultasi berhasil diperbarui.');
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
    $konsultasi->delete();

    return redirect()->route('konsultasi.index')->with('success', 'Konsultasi berhasil dihapus.');
}

    public function myKonsultasi()
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
        return view('user.konsultasi.my_konsultasi', compact('daftar_konsultasi'));
    }