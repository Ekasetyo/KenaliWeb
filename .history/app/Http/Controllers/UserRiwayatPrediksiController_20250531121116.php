<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use MongoDB\BSON\ObjectId;
use Carbon\Carbon;

class UserRiwayatPrediksiController extends Controller
{
    public function dataPrediksi(Request $request)
    {
        // Ambil id user yang sedang login dari sesi
        $user = Session::get('user');
        if (!$user || !isset($user['id'])) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        $userId = new ObjectId($user['id']);

        $search = $request->input('search');

        // Ambil data dari hasil_deteksi berdasarkan user_id yang login
        $dataCursor = DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('hasil_deteksi')
            ->find(['user_id' => $userId]); // Filter berdasarkan user_id

        $dataArray = iterator_to_array($dataCursor);

        // Ambil data dari users untuk user yang login (opsional, jika perlu data tambahan)
        $usersCursor = DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('users')
            ->find(['_id' => $userId]);
        
        $usersArray = iterator_to_array($usersCursor);
        $usersMap = [];
        foreach ($usersArray as $userData) {
            $usersMap[(string)$userData->_id] = $userData; // Simpan dalam array dengan _id sebagai key
        }

        // Gabungkan data
        foreach ($dataArray as $item) {
            $item->user = $usersMap[$item->user_id] ?? null; // Tambahkan data user ke item
        }

        // Proses data untuk menambahkan usia
        foreach ($dataArray as $item) {
            // Inisialisasi default
            $item->name = $item->user->name ?? '-';
            $item->age = $item->age ?? '-';

            // Hitung usia berdasarkan tanggal_lahir jika tersedia
            if (isset($item->user->tanggal_lahir)) {
                try {
                    $item->age = Carbon::parse($item->user->tanggal_lahir)->age;
                } catch (\Exception $e) {
                    $item->age = $item->age; // Fallback ke age dari hasil_deteksi
                }
            }
        }

        // Buat objek paginasi
        $data = new \Illuminate\Pagination\LengthAwarePaginator(
            $dataArray,
            count($dataArray), // Total jumlah item
            10, // Per halaman
            $request->input('page', 1),
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('user.riwayat-deteksi.index', [
            'data' => $data,
            'usersRaw' => collect($dataArray)->mapWithKeys(function ($item) {
                return [$item->user_id => (object) [
                    'name' => $item->name,
                    'tanggal_lahir' => $item->user->tanggal_lahir ?? null
                ]];
            })
        ]);
    }
}