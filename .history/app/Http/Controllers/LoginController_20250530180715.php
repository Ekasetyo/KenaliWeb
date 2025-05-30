<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use MongoDB\Client as MongoClient;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

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

        // Cek apakah sudah ada sesi aktif, jika ada, hapus sesi sebelumnya
        if (Session::has('user')) {
            $currentUser = Session::get('user');
            Session::forget('user'); // Hapus sesi sebelumnya
            Log::info('Sesi sebelumnya dihapus untuk user:', ['email' => $currentUser['email']]);
        }

        try {
            // Koneksi ke MongoDB
            $mongoClient = new MongoClient(env('DB_CONNECTION_STRING'));
            $db = $mongoClient->kenali;
            $collection = $db->users;

            // Cari user berdasarkan email
            $user = $collection->findOne(['email' => $request->email]);

            if (!$user) {
                $response = ['message' => 'Email tidak ditemukan'];
                return $request->wantsJson() ? response()->json($response, 404) : back()->with('error', $response['message']);
            }

            // Verifikasi password menggunakan Hash::check
            if (Hash::check($request->password, $user->password)) {
                // Simpan data user di session
                Session::put('user', [
                    'id' => (string)$user->_id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'status' => $user->status
                ]);
                Session::save();
                Log::info('Login successful, session user:', [Session::get('user')]);

                $response = [
                    'message' => 'Login berhasil',
                    'user' => [
                        'id' => (string)$user->_id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'status' => $user->status
                    ]
                ];

                // Redirect berdasarkan status
                if ($user->status === 'admin') {
                    return $request->wantsJson()
                        ? response()->json($response, 200)
                        : redirect()->route('admin.dashboard')->with('success', 'Login berhasil sebagai admin!');
                } else {
                    return $request->wantsJson()
                        ? response()->json($response, 200)
                        : redirect()->route('user.dashboard')->with('success', 'Login berhasil!');
                }
            } else {
                $response = ['message' => 'Password salah'];
                return $request->wantsJson() ? response()->json($response, 401) : back()->with('error', $response['message']);
            }
        } catch (\Exception $e) {
            $response = ['message' => 'Terjadi kesalahan: ' . $e->getMessage()];
            return $request->wantsJson() ? response()->json($response, 500) : back()->with('error', $response['message']);
        }
    }

    public function logout()
    {
        Session::forget('user');
        return redirect('/')->with('success', 'Logout berhasil!');
    }
}