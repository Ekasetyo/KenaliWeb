<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\PredictionHistory; // Import model Prediction

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('login.session');
    }

    public function ubahPassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed|min:6',
        ]);

        $userId = session('user_id');
        $user = User::find($userId);

        if (!$user) {
            return back()->with('error', 'User belum login.');
        }

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->with('error', 'Password lama salah.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password berhasil diubah.');
    }

    public function dashboard()
    {
        return view('user.dashboard.index');
    }

    public function konsultasi()
    {
        return view('user.konsultasi.index');
    }

    public function laporan()
    {
        // Ambil user_id dari session atau Auth
        $userId = session('user_id'); 
        // Jika kamu menggunakan Auth, bisa juga: $userId = Auth::id();

        // Ambil prediksi berdasarkan user_id, urutkan terbaru
        $predictions = PredictionHistory::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Kirim data ke view
        return view('user.riwayat-deteksi.index', compact('predictions'));
    }
}
