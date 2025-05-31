<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request)
{
    $identifier = $request->input('identifier');

    if (!$identifier) {
        return redirect()->back()->withErrors(['identifier' => 'Nama diperlukan.']);
    }

    return view('login-register.forgot-password', [
        'identifier' => $identifier
    ]);
}

public function reset(Request $request)
{
    $identificationColumn = 'name';

    $request->validate([
        'identifier' => 'required|string|exists:users,' . $identificationColumn,
        'password' => [
            'required',
            'string',
            'min:8',
            'regex:/[A-Z]/', // huruf kapital
            'regex:/[0-9]/', // angka
            'regex:/[@$!%*?&]/', // karakter khusus
            'confirmed',
        ],
    ], [
        'identifier.exists' => 'Pengguna tidak ditemukan.',
        'password.regex' => 'Password harus mengandung huruf kapital, angka, dan karakter khusus.',
        'password.min' => 'Password minimal 8 karakter.',
        'password.confirmed' => 'Konfirmasi password tidak cocok.',
    ]);

    $user = User::where($identificationColumn, $request->identifier)->first();

    if (!$user) {
        return back()->withErrors(['identifier' => 'Pengguna tidak ditemukan.']);
    }

    $user->password = Hash::make($request->password);
    $user->save();

    return redirect()->route('login')->with('success', 'Password berhasil direset!');
}

}