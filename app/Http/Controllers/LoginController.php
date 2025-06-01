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

        // Clear previous session if exists
        if (Session::has('user')) {
            Session::forget('user');
        }

        try {
            $mongoClient = new MongoClient(env('DB_CONNECTION_STRING'));
            $db = $mongoClient->kenali;
            $collection = $db->users;

            $user = $collection->findOne(['email' => $request->email]);

            if (!$user) {
                return back()->with('error', 'Email tidak ditemukan');
            }

            if (Hash::check($request->password, $user->password)) {
                $userData = [
                    'id' => (string)$user->_id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'status' => $user->status // Pastikan field status ada di koleksi users
                ];
                
                Session::put('user', $userData);
                
                // Redirect berdasarkan status
                if ($user->status === 'admin') {
                    return redirect()->route('admin.dashboard')->with('success', 'Login berhasil sebagai admin!');
                }
                    return redirect()->route('user.dashboard');
            }

            return back()->with('error', 'Password salah');

        } catch (\Exception $e) {
            Log::error('Login error: '.$e->getMessage());
            return back()->with('error', 'Terjadi kesalahan sistem');
        }
    }

    public function logout()
    {
        Session::forget('user');
        return redirect('/')->with('success', 'Logout berhasil!');
    }
}