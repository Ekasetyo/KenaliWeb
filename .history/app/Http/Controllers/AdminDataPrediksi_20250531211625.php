<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use MongoDB\BSON\ObjectId;
use Carbon\Carbon;

class AdminDataPrediksi extends Controller
{
    public function dataPrediksi(Request $request)
    {
        $search = $request->input('search');

        // Ambil data dari hasil_deteksi
        $dataCursor = DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('hasil_deteksi')
            ->find();

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
            $usersMap[(string)$user->_id] = $user;
        }

        // Gabungkan data
        foreach ($dataArray as $item) {
            $item->user = $usersMap[$item->user_id] ?? null;
        }

        // Filter berdasarkan pencarian
        if ($search) {
            $dataArray = array_filter($dataArray, function ($item) use ($search) {
                return stripos($item->user->name ?? '', $search) !== false;
            });
        }

        // Proses data untuk menambahkan usia
        foreach ($dataArray as $item) {
            $item->name = $item->user->name ?? '-';
            $item->age = $item->age ?? '-';

            if (isset($item->user->tanggal_lahir)) {
                try {
                    $item->age = Carbon::parse($item->user->tanggal_lahir)->age;
                } catch (\Exception $e) {
                    $item->age = $item->age;
                }
            }
        }

        // Buat objek paginasi
        $data = new \Illuminate\Pagination\LengthAwarePaginator(
            $dataArray,
            count($dataArray),
            10,
            $request->input('page', 1),
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.hasil-prediksi.index', [
            'data' => $data,
            'usersRaw' => collect($dataArray)->mapWithKeys(function ($item) {
                return [$item->user_id => (object) [
                    'name' => $item->name,
                    'tanggal_lahir' => $item->user->tanggal_lahir ?? null
                ]];
            })
        ]);
    }

    public function showDetail($id)
    {
        // Ambil data dari hasil_deteksi berdasarkan _id
        try {
            $data = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('hasil_deteksi')
                ->findOne(['_id' => new ObjectId($id)]);
        } catch (\Exception $e) {
            return redirect()->route('admin.hasil-prediksi')->with('error', 'Data tidak ditemukan.');
        }

        if (!$data) {
            return redirect()->route('admin.hasil-prediksi')->with('error', 'Data tidak ditemukan.');
        }

        // Ambil data pengguna
        try {
            $userData = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('users')
                ->findOne(['_id' => new ObjectId($data->user_id)]);
        } catch (\Exception $e) {
            $userData = null;
        }

        $data->user = $userData;
        $data->name = $userData->name ?? '-';

        return view('admin.hasil-prediksi.detail', ['data' => $data]);
    }
}