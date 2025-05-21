<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;
use MongoDB\BSON\UTCDateTime;

class DatauserController extends Controller
{
    public function index(Request $request)
    {
        if (!Session::has('user') || Session::get('user')['status'] !== 'admin') {
            Alert::error('Akses Ditolak', 'Anda tidak memiliki akses');
            return redirect('/login');
        }

        try {
            $search = $request->input('search');
            
            $users = User::when($search, function($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%")
                      ->orWhere('no_telepon', 'like', "%$search%");
            })
            ->paginate(10); // 10 item per halaman

            return view('admin.user.index', compact('users'));
        } catch (\Exception $e) {
            Alert::error('Error', 'Gagal mengambil data: ' . $e->getMessage());
            return back();
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')
            ],
            'password' => 'required|string|min:6',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'no_telepon' => [
                'required',
                'string',
                'max:20',
                Rule::unique('users', 'no_telepon')
            ],
            'alamat' => 'required|string',
            'status' => 'required|in:admin,user',
        ], [
            'email.unique' => 'Email ini sudah terdaftar',
            'no_telepon.unique' => 'Nomor telepon ini sudah terdaftar'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $users = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'no_telepon' => $request->no_telepon,
                'alamat' => $request->alamat,
                'status' => $request->status,
            ]);

            Alert::success('Berhasil!', 'User berhasil ditambahkan');
            return redirect()->route('admin.user.index');
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Terjadi kesalahan: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $user = User::findOrFail($id);
            return view('admin.user.edit', compact('user'));
        } catch (\Exception $e) {
            Alert::error('Error', 'User tidak ditemukan');
            return redirect()->route('admin.user.index');
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($id, '_id')
            ],
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'no_telepon' => [ 
                'required',
                'string',
                'max:20',
                Rule::unique('users', 'no_telepon')->ignore($id, '_id')
            ],
            'alamat' => 'required|string',
            'status' => 'required|in:admin,user',
        ], [
            'email.unique' => 'Email ini sudah terdaftar',
            'no_telepon.unique' => 'Nomor telepon ini sudah terdaftar'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $user = User::findOrFail($id);
            $user->update($request->all());

            Alert::success('Berhasil!', 'Data user berhasil diperbarui');
            return redirect()->route('admin.user.index');
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Terjadi kesalahan: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            Alert::success('Berhasil!', 'User berhasil dihapus');
            return redirect()->route('admin.user.index');
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Terjadi kesalahan: ' . $e->getMessage());
            return back();
        }
    }
}