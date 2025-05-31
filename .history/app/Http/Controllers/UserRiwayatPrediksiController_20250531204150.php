<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
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
            Log::error('User session not found or invalid');
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        Log::info('User session:', [$user]);
        $userId = (string)$user['id'];

        $search = $request->input('search');

        // Ambil data dari hasil_deteksi berdasarkan user_id yang login
        $query = ['user_id' => $userId];
        $dataCursor = DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('hasil_deteksi')
            ->find($query);
        $dataArray = iterator_to_array($dataCursor);
        Log::info('Hasil deteksi:', $dataArray);

        // Ambil data dari users untuk user yang login
        try {
            $usersCursor = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('users')
                ->find(['_id' => new ObjectId($userId)]);
        } catch (\Exception $e) {
            Log::error('Error converting user_id to ObjectId: ' . $e->getMessage());
            $usersCursor = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('users')
                ->find(['_id' => $userId]);
        }
        $usersArray = iterator_to_array($usersCursor);
        \Log::info('Users data:', $usersArray);

        $usersMap = [];
        foreach ($usersArray as $userData) {
            $usersMap[(string)$userData->_id] = $userData;
        }

        // Gabungkan data
        foreach ($dataArray as $item) {
            $item->user = $usersMap[(string)$item->user_id] ?? null;
            \Log::info('Item user_id:', [(string)$item->user_id, 'user' => $item->user]);
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
                    \Log::error('Error parsing tanggal_lahir: ' . $e->getMessage());
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