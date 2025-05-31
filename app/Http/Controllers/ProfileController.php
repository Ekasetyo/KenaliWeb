<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('login.session'); // Ganti middleware ke login.session
    }

    public function update(Request $request)
    {
        // Ambil data pengguna dari sesi (sesuaikan dengan logika login.session)
        $user = session('user');

        // Jika sesi tidak ada, arahkan ke halaman login
        if (!$user) {
            \Log::warning('User session invalid during profile update');
            return redirect()->route('login')->with('error', 'Sesi Anda telah habis. Silakan login kembali.');
        }

        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user['id'], // Sesuaikan dengan struktur data sesi
            'jenis_kelamin' => 'nullable|string|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'nullable|date',
            'no_telepon' => 'nullable|string',
            'alamat' => 'nullable|string',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'tanggal_lahir.date' => 'Tanggal lahir harus dalam format yang valid.',
        ]);

        try {
            // Update data pengguna di database
            $userModel = \App\Models\User::find($user['id']); // Sesuaikan dengan struktur data sesi
            $userModel->update($validated);

            // Update data di sesi
            $updatedUser = array_merge($user, $validated);
            session(['user' => $updatedUser]);

            return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
        } catch (\Exception $e) {
            \Log::error('Error updating profile: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui profil: ' . $e->getMessage());
        }
    }

    public function updatePassword(Request $request)
    {
        // Ambil data pengguna dari sesi
        $user = session('user');

        // Jika sesi tidak ada, arahkan ke halaman login
        if (!$user) {
            \Log::warning('User session invalid during password update');
            return redirect()->route('login')->with('error', 'Sesi Anda telah habis. Silakan login kembali.');
        }

        // Validasi input
        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&]/',
                'confirmed',
            ],
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'new_password.regex' => 'Password harus mengandung huruf kapital, angka, dan karakter khusus (@$!%*?&).',
            'new_password.min' => 'Password minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Ambil data pengguna dari database untuk memverifikasi password
        $userModel = \App\Models\User::find($user['id']);

        // Periksa password lama
        if (!Hash::check($request->current_password, $userModel->password)) {
            return back()->with('error', 'Password lama tidak cocok.');
        }

        try {
            // Update password di database
            $userModel->password = Hash::make($request->new_password);
            $userModel->save();

            return back()->with('success', 'Password berhasil diperbarui.');
        } catch (\Exception $e) {
            \Log::error('Error updating password: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui password: ' . $e->getMessage());
        }
    }
}