<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterUserController extends Controller
{
    public function showRegistrationForm()
    {
        return view('login-register.register'); // sesuaikan dengan path view kamu
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
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
        ]);

        User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'status' => 'User', // default status user
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil!');
    }
}
