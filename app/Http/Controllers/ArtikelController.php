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
            'judul' => 'required|min:5|max:255',
            'deskripsi' => 'required|min:20',
            'penulis' => 'required|max:100',
            'sumber' => 'required|url|max:255'
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
            'judul' => 'required|min:5|max:255',
            'deskripsi' => 'required|min:20',
            'penulis' => 'required|max:100',
            'sumber' => 'required|url|max:255'
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
