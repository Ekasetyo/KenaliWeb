<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MongoDB\Client as MongoClient;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class RegisterUserController extends Controller
{
    public function showRegistrationForm()
    {
        return view('login-register.register');
    }

    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',       // Huruf kapital
                'regex:/[0-9]/',       // Angka
                'regex:/[@$!%*?&]/',   // Karakter khusus
                'confirmed',
            ],
        ], [
            'password.regex' => 'Password harus mengandung huruf kapital, angka, dan karakter khusus (@$!%*?&).',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'email.unique' => 'Email sudah terdaftar.',
        ]);

        try {
            // Koneksi ke MongoDB
            $mongoClient = new MongoClient(env('DB_CONNECTION_STRING'));
            $db = $mongoClient->kenali;
            $collection = $db->users;

            // Cek apakah email sudah ada
            $existingUser = $collection->findOne(['email' => $request->email]);
            if ($existingUser) {
                return back()->with('error', 'Email sudah terdaftar.');
            }

            // Data pengguna baru
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => password_hash($request->password, PASSWORD_DEFAULT),
                'status' => 'user', // Status huruf kecil untuk konsistensi
                'jenis_kelamin' => '',
                'tanggal_lahir' => '',
                'no_telepon' => '',
                'alamat' => '',
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ];

            // Simpan pengguna ke MongoDB
            $result = $collection->insertOne($userData);

            // Simpan data pengguna ke sesi (opsional, jika ingin login otomatis)
            $sessionData = [
                'id' => (string)$result->getInsertedId(),
                'name' => $userData['name'],
                'email' => $userData['email'],
                'status' => $userData['status'],
                'jenis_kelamin' => $userData['jenis_kelamin'],
                'tanggal_lahir' => $userData['tanggal_lahir'],
                'no_telepon' => $userData['no_telepon'],
                'alamat' => $userData['alamat'],
            ];
            Session::put('user', $sessionData);

            // Log untuk debugging
            Log::info('User registered and logged in', ['user' => $sessionData]);

            // Redirect ke dashboard pengguna (karena sudah login otomatis)
            return redirect()->route('user.dashboard')->with('success', 'Registrasi berhasil! Anda telah login.');
        } catch (\Exception $e) {
            Log::error('Registration error', ['error' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}