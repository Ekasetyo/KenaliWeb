<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Konsultasi;
use Illuminate\Support\Facades\Session;
use MongoDB\BSON\ObjectId;
use RealRashid\SweetAlert\Facades\Alert;

class AdminKonsultasi extends Controller
{
    public function index(Request $request)
    {
        if (!Session::has('user') || Session::get('user')['status'] !== 'admin') {
            Alert::error('Akses Ditolak', 'Anda tidak memiliki akses');
            return redirect('/login');
        }

        $query = Konsultasi::with('pengguna');

        // Filter by status
        $status = $request->input('status', 'all');
        if ($status != 'all') {
            if ($status == 'active') {
                $query->whereNull('jawaban');
            } elseif ($status == 'completed') {
                $query->whereNotNull('jawaban');
            }
        }

        // Filter by date
        if ($date = $request->input('date')) {
            $query->whereDate('created_at', $date);
        }

        // Filter by search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('identitas', 'like', "%$search%")
                  ->orWhere('keluhan', 'like', "%$search%")
                  ->orWhereHas('pengguna', function ($q) use ($search) {
                      $q->where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%");
                  });
            });
        }

        $daftar_konsultasi = $query->latest()->get();
        return view('admin.konsultasi.index', compact('daftar_konsultasi'));
    }

    public function show($id)
    {
        if (!Session::has('user') || Session::get('user')['status'] !== 'admin') {
            Alert::error('Akses Ditolak', 'Anda tidak memiliki akses');
            return redirect('/login');
        }

        try {
            $id = new ObjectId($id);
        } catch (\Exception $e) {
            Alert::error('Error', 'ID tidak valid.');
            return redirect()->route('admin.konsultasi.index');
        }

        $konsultasi = Konsultasi::where('_id', $id)->with('pengguna')->firstOrFail();
        return view('admin.konsultasi.detail', compact('konsultasi'));
    }

        public function reply(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'jawaban' => 'required|string',
            'nama_pemberi_jawaban' => 'required|string|max:255',
        ], [
            'jawaban.required' => 'Jawaban wajib diisi.',
            'nama_pemberi_jawaban.required' => 'Nama pemberi jawaban wajib diisi.',
            'nama_pemberi_jawaban.max' => 'Nama pemberi jawaban maksimal 255 karakter.',
        ]);

        try {
            $id = new ObjectId($request->id);
        } catch (\Exception $e) {
            Alert::error('Error', 'ID tidak valid.');
            return redirect()->route('admin.konsultasi.index');
        }

        $konsultasi = Konsultasi::where('_id', $id)->firstOrFail();
        $konsultasi->update([
            'jawaban' => $request->jawaban,
            'nama_pemberi_jawaban' => $request->nama_pemberi_jawaban,
        ]);

        Alert::success('Berhasil!', 'Jawaban berhasil dikirim.');
        return redirect()->route('admin.konsultasi.index');
    }
}