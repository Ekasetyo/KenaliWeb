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
        $search = $request->input('search');

        // Ambil data dari hasil_deteksi
        $dataCursor = DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('hasil_deteksi')
            ->find(); // Sesuaikan query Anda

        $dataArray = iterator_to_array($dataCursor);

        // Ambil data dari users
        $userIds = array_column($dataArray, 'user_id');
        $usersCursor = DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('users')
            ->find(['_id' => ['$in' => array_map(function($id) { return new ObjectId($id); }, $userIds)]]);
        
        $usersArray = iterator_to_array($usersCursor);
        $usersMap = [];
        foreach ($usersArray as $user) {
            $usersMap[(string)$user->_id] = $user; // Simpan dalam array dengan _id sebagai key
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