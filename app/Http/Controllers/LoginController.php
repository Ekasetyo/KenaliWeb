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
            $mongoClient = new MongoClient(env('DB_CONNECTION_STRING'));
            $db = $mongoClient->kenali; // Ganti 'your_database_name' dengan nama database Anda
            $collection = $db->users;

            $user = $collection->findOne(['email' => $request->email]);

            if (!$user) {
                $response = ['message' => 'Email tidak ditemukan'];
                return $request->wantsJson() ? response()->json($response, 404) : back()->with('error', $response['message']);
            }

            // Verifikasi password
            // Pastikan password di database sudah di-hash dengan password_hash() atau bcrypt() Laravel
            if (password_verify($request->password, $user->password)) {
                // Simpan SEMUA data user yang relevan ke session
                Session::put('user', [
                    'id' => (string)$user->_id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'status' => $user->status, // Pastikan ini ada dan bernilai 'user' atau 'admin'
                    'jenis_kelamin' => $user->jenis_kelamin ?? null, // Tambahkan ini
                    'tanggal_lahir' => isset($user->tanggal_lahir) ? (string)$user->tanggal_lahir : null, // Tambahkan ini, cast ke string jika perlu
                    'no_telepon' => $user->no_telepon ?? null, // Tambahkan ini
                    'alamat' => $user->alamat ?? null, // Tambahkan ini
                    'password' => $user->password, // Simpan hash password untuk verifikasi 'password lama'
                ]);

                $response = [
                    'message' => 'Login berhasil',
                    'user' => [
                        'id' => (string)$user->_id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'status' => $user->status
                    ]
                ];

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

 public function logout(Request $request)
{
    // Hapus semua session user
    $request->session()->forget('user');
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Redirect ke halaman login
    return redirect()->route('login');
}
}