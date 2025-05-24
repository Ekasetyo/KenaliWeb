<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('login.session'); // pastikan hanya user yang login yang bisa akses
    }

    public function ubahPassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed|min:6',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Password lama salah']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password berhasil diubah');
    }

    public function dashboard()
    {
        return view('user.dashboard.index');
    }

    public function riwayatPrediksi()
    {
        return view('user.riwayat-prediksi.index');
    }

    public function laporan()
    {
        return view('user.laporan.index');
    }
}
