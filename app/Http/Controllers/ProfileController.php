<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('login.session'); // Proteksi hanya untuk yang sudah login
    }

    /**
     * Update data profil user (nama, email, dll)
     */
    public function update(Request $request)
    {
        // Ambil data user dari session
        $user = session('user');

        if (!$user) {
            Log::warning('User session invalid during profile update');
            return redirect()->route('login')->with('error', 'Sesi Anda telah habis. Silakan login kembali.');
        }

        // Validasi input
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|max:255|unique:users,email,' . $user['id'],
            'jenis_kelamin'  => 'nullable|string|in:Laki-laki,Perempuan',
            'tanggal_lahir'  => 'nullable|date',
            'no_telepon'     => 'nullable|string|max:20',
            'alamat'         => 'nullable|string|max:255',
        ], [
            'name.required'       => 'Nama wajib diisi.',
            'email.required'      => 'Email wajib diisi.',
            'email.email'         => 'Email tidak valid.',
            'email.unique'        => 'Email sudah digunakan.',
            'tanggal_lahir.date'  => 'Tanggal lahir harus format valid.',
        ]);

        try {
            // Temukan user di database
            $userModel = User::find($user['id']);
            if (!$userModel) {
                return back()->with('error', 'Data pengguna tidak ditemukan.');
            }

            // Simpan perubahan
            $userModel->update($validated);

            // Update session user
            $updatedUser = array_merge($user, $validated);
            session(['user' => $updatedUser]);

            return back()->with('success', 'Profil berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating profile: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui profil: ' . $e->getMessage());
        }
    }

    /**
     * Update password user
     */
    public function updatePassword(Request $request)
    {
        // Ambil user dari session
        $user = session('user');

        if (!$user) {
            Log::warning('User session invalid during password update');
            return redirect()->route('login')->with('error', 'Sesi Anda telah habis. Silakan login kembali.');
        }

        // Validasi input
        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',       // huruf kapital
                'regex:/[0-9]/',       // angka
                'regex:/[@$!%*?&]/',   // karakter khusus
                'confirmed',           // new_password_confirmation harus cocok
            ],
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'new_password.regex'        => 'Password harus mengandung huruf kapital, angka, dan karakter khusus (@$!%*?&).',
            'new_password.min'          => 'Password minimal 8 karakter.',
            'new_password.confirmed'    => 'Konfirmasi password tidak cocok.',
        ]);

        // Ambil user dari database
        $userModel = User::find($user['id']);
        if (!$userModel) {
            return back()->with('error', 'Data pengguna tidak ditemukan.');
        }

        // Verifikasi password lama
        if (!Hash::check($request->current_password, $userModel->password)) {
            return back()->with('error', 'Password lama tidak cocok.');
        }

        try {
            // Update password
            $userModel->password = Hash::make($request->new_password);
            $userModel->save();

            return back()->with('success', 'Password berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating password: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui password: ' . $e->getMessage());
        }
    }
}
