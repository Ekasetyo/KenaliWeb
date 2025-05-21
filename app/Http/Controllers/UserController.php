<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
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

    public function riwayatPrediksi()
    {
        return view('user.riwayat-prediksi.index');
    }

    public function laporan()
    {
        return view('user.laporan.index');
    }
}
