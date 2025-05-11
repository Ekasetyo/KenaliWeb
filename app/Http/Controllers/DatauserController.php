<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MongoDB\Client as MongoClient;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use MongoDB\BSON\ObjectId;

class DatauserController extends Controller
{
    public function index()
    {
        // Pastikan hanya admin yang bisa mengakses
        if (!Session::has('user') || Session::get('user')['status'] !== 'admin') {
            return redirect('/login')->with('error', 'Anda tidak memiliki akses');
        }

        try {
            $mongoClient = new MongoClient(env('DB_CONNECTION_STRING'));
            $db = $mongoClient->kenali;
            $collection = $db->users;

            $users = $collection->find([], [
                'projection' => [
                    'password' => 0
                ]
            ]);

            // Debugging: Cek data sebelum dikirim ke view
            // dd(iterator_to_array($users));

            $usersArray = iterator_to_array($users->toArray()); // Konversi ke array

            return view('admin.user.index', [
                'users' => $usersArray // Kirim array ke view
            ]);

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengambil data: '.$e->getMessage());
        }
    }


    public function store(Request $request)
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'no_telepon' => 'required|string|max:20',
            'alamat' => 'required|string',
            'status' => 'required|in:admin,user',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $mongoClient = new MongoClient(env('DB_CONNECTION_STRING'));
            $db = $mongoClient->kenali;
            $collection = $db->users;

            // Enkripsi password
            $hashedPassword = Hash::make($request->password);

            // Siapkan data untuk disimpan
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $hashedPassword,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'no_telepon' => $request->no_telepon,
                'alamat' => $request->alamat,
                'status' => $request->status,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Simpan data ke MongoDB
            $insertOneResult = $collection->insertOne($userData);

            if ($insertOneResult->getInsertedCount() > 0) {
                return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan.');
            } else {
                return back()->with('error', 'Gagal menambahkan user.');
            }

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }


     
}