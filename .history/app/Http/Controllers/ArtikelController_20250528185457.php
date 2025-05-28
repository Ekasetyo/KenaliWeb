<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class ArtikelController extends Controller
{
    public function index()
    {
        // Cek akses
        if (!Session::has('user') || Session::get('user')['status'] !== 'admin') {
            Alert::error('Akses Ditolak', 'Anda tidak memiliki akses');
            return redirect('/login');
        }

        // Ambil data artikel
        $artikels = Artikel::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.artikel.index', [
            'artikels' => $artikels
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|min:10|max:255',
            'deskripsi' => 'required|min:100',
            'penulis' => 'required|min:3|max:100',
            'sumber' => 'required|url|max:255'
        ], [
            'judul.required' => 'Judul artikel wajib diisi',
            'judul.min' => 'Judul minimal harus 10 karakter',
            'judul.max' => 'Judul maksimal 255 karakter',
            'deskripsi.required' => 'Deskripsi artikel wajib diisi',
            'deskripsi.min' => 'Deskripsi minimal harus 100 karakter',
            'penulis.required' => 'Nama penulis wajib diisi',
            'penulis.min' => 'Nama penulis minimal 3 karakter',
            'penulis.max' => 'Nama penulis maksimal 100 karakter',
            'sumber.required' => 'Sumber artikel wajib diisi',
            'sumber.url' => 'Format sumber harus berupa URL',
            'sumber.max' => 'Sumber maksimal 255 karakter'
        ]);

        Artikel::create($request->only(['judul', 'deskripsi', 'penulis', 'sumber']));

        Alert::success('Berhasil!', 'Artikel berhasil ditambahkan');
        return redirect()->route('admin.artikel.index');
    }

    public function edit($id)
    {
        $artikel = Artikel::findOrFail($id);
        return view('admin.artikel.edit', compact('artikel'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|min:10|max:255',
            'deskripsi' => 'required|min:100',
            'penulis' => 'required|min:3|max:100',
            'sumber' => 'required|url|max:255'
        ], [
            'judul.required' => 'Judul artikel wajib diisi',
            'judul.min' => 'Judul minimal harus 10 karakter',
            'judul.max' => 'Judul maksimal 255 karakter',
            'deskripsi.required' => 'Deskripsi artikel wajib diisi',
            'deskripsi.min' => 'Deskripsi minimal harus 100 karakter',
            'penulis.required' => 'Nama penulis wajib diisi',
            'penulis.min' => 'Nama penulis minimal 3 karakter',
            'penulis.max' => 'Nama penulis maksimal 100 karakter',
            'sumber.required' => 'Sumber artikel wajib diisi',
            'sumber.url' => 'Format sumber harus berupa URL',
            'sumber.max' => 'Sumber maksimal 255 karakter'
        ]);

        // Update artikel
        Artikel::findOrFail($id)->update($request->only(['judul', 'deskripsi', 'penulis', 'sumber']));

        Alert::success('Berhasil!', 'Artikel berhasil diperbarui');
        return redirect()->route('admin.artikel.index');
    }

    public function landing()
    {
        $artikels = Artikel::orderBy('created_at', 'desc')->paginate(5);
        return view('landing-page.landing-page', compact('artikels'));
    }   

    public function destroy($id)
    {
        try {
            $artikel = Artikel::findOrFail($id);
            $artikel->delete();

            Alert::success('Berhasil!', 'Artikel berhasil dihapus');
            return redirect()->route('admin.artikel.index');
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Terjadi kesalahan: ' . $e->getMessage());
            return back();
        }
    }
}