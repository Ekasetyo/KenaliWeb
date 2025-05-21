<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use MongoDB\Client as MongoClient;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login-register.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        try {
            // Koneksi ke MongoDB
            $mongoClient = new MongoClient(env('DB_CONNECTION_STRING'));
            $db = $mongoClient->kenali; // Nama database Anda
            $collection = $db->users; // Nama collection

            // Cari user berdasarkan email
            $user = $collection->findOne(['email' => $request->email]);

            if (!$user) {
                return back()->with('error', 'Email tidak ditemukan');
            }

            // Verifikasi password
            if (password_verify($request->password, $user->password)) {
                // Simpan data user di session
                Session::put('user', [
                    'id' => (string)$user->_id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'status' => $user->status
                ]);

                // Redirect berdasarkan status
                if ($user->status === 'admin') {
                    return redirect()->route('admin.dashboard')->with('success', 'Login berhasil sebagai admin!');
                } else {
                    return redirect()->route('user.dashboard')->with('success', 'Login berhasil!');
                }
            } else {
                return back()->with('error', 'Password salah');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function logout()
    {
    Session::forget('user'); // Hapus session user
    Session::flush(); // (Opsional) Hapus semua session jika perlu
    return redirect('/')->with('success', 'Logout berhasil!');
    }
}