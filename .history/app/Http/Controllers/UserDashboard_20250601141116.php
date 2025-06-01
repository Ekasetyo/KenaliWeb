<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use MongoDB\BSON\UTCDateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UserDashboard extends Controller
{
    public function dashboard()
    {
        // Cek akses
        if (!Session::has('user') || Session::get('user')['status'] !== 'user') {
            Alert::error('Akses Ditolak', 'Anda tidak memiliki akses');
            return redirect('/login');
        }

        $userId = Session::get('user')['id'];

        // Inisialisasi data default
        $data = [
            'deteksiCount' => 0,
            'deteksiRisk' => ['Beresiko' => 0, 'Tidak Beresiko' => 0],
            'konsultasiCount' => 0,
            'konsultasiPerMonth' => array_fill(0, 12, 0),
        ];

        // Ambil data untuk dashboard
        $deteksiData = $this->getDeteksiData($userId);
        $konsultasiData = $this->getKonsultasiData($userId);

        // Gabungkan data dengan default
        $data = array_merge($data, $deteksiData, $konsultasiData);

        Log::info('Final Dashboard Data:', $data);

        return view('user.dashboard.index', $data);
    }

    private function getDeteksiData($userId)
{
    $deteksiCount = 0;
    $deteksisPerMonthArray = array_fill(0, 12, 0);

    try {
        $deteksisPerMonth = DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('hasil_deteksi')
            ->aggregate([
                [
                    '$match' => [
                        'user_id' => new \MongoDB\BSON\ObjectId($userId),
                    ],
                ],
                [
                    '$group' => [
                        '_id' => ['$month' => '$created_at'],
                        'count' => ['$sum' => 1],
                    ],
                ],
                ['$sort' => ['_id' => 1]],
            ]);

        $deteksisPerMonthArrayRaw = iterator_to_array($deteksisPerMonth);

        foreach ($deteksisPerMonthArrayRaw as $data) {
            $monthIndex = $data['_id'] - 1;
            if ($monthIndex >= 0 && $monthIndex < 12) {
                $deteksisPerMonthArray[$monthIndex] = $data['count'];
            }
        }

        $deteksiCount = array_sum($deteksisPerMonthArray);
    } catch (\Exception $e) {
        Log::error('Error Fetching Deteksi Data for User ' . $userId . ': ' . $e->getMessage());
    }

    return [
        'deteksiCount' => $deteksiCount,
        'deteksisPerMonth' => $deteksisPerMonthArray,
    ];
}

    private function getKonsultasiData($userId)
    {
        $konsultasiCount = 0;
        $konsultasisPerMonthArray = array_fill(0, 12, 0);

        try {
            // Ambil data konsultasi per bulan
            $konsultasisPerMonth = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('konsultasis')
                ->aggregate([
                    [
                        '$match' => [
                            'id_pengguna' => new \MongoDB\BSON\ObjectId($userId),
                        ],
                    ],
                    [
                        '$group' => [
                            '_id' => ['$month' => '$created_at'],
                            'count' => ['$sum' => 1],
                        ],
                    ],
                    ['$sort' => ['_id' => 1]],
                ]);

            $konsultasisPerMonthArrayRaw = iterator_to_array($konsultasisPerMonth);

            foreach ($konsultasisPerMonthArrayRaw as $data) {
                $monthIndex = $data['_id'] - 1;
                if ($monthIndex >= 0 && $monthIndex < 12) {
                    $konsultasisPerMonthArray[$monthIndex] = $data['count'];
                }
            }

            $konsultasiCount = array_sum($konsultasisPerMonthArray);
        } catch (\Exception $e) {
            Log::error('Error Fetching Konsultasi Data for User ' . $userId . ': ' . $e->getMessage());
        }

        return [
            'konsultasiCount' => $konsultasiCount,
            'konsultasiPerMonth' => $konsultasisPerMonthArray,
        ];
    }
}