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
            'konsultasiPerDay' => array_fill(0, 31, 0),
        ];

        // Ambil data untuk dashboard
        $deteksiData = $this->getDeteksiData($userId);
        $konsultasiData = $this->getKonsultasiData($userId);

        // Gabungkan data dengan default
        $data = array_merge($data, $deteksiData ?? [], $konsultasiData ?? []);

        Log::info('Final Dashboard Data:', $data);

        return view('user.dashboard.index', $data);
    }

    private function getDeteksiData($userId)
    {
        $deteksiCount = 0;
        $deteksiRisk = ['Beresiko' => 0, 'Tidak Beresiko' => 0];

        try {
            $currentDate = new \DateTime();
            $startDate = $currentDate->modify('first day of this month')->setTime(0, 0, 0);
            $endDate = $currentDate->modify('last day of this month')->setTime(23, 59, 59);

            $startTimestamp = $startDate->getTimestamp() * 1000;
            $endTimestamp = $endDate->getTimestamp() * 1000;

            $dataCursor = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('hasil_deteksi')
                ->find([
                    'user_id' => $userId,
                    'created_at' => [
                        '$gte' => new UTCDateTime($startTimestamp),
                        '$lte' => new UTCDateTime($endTimestamp),
                    ],
                ]);
            $dataArray = iterator_to_array($dataCursor);
            Log::info('Raw Deteksi Data for User ' . $userId . ':', $dataArray);
            $deteksiCount = count($dataArray);

            foreach ($dataArray as $deteksi) {
                $prediction = strtolower($deteksi['prediction'] ?? '');
                if (strpos($prediction, 'beresiko') !== false) {
                    $deteksiRisk['Beresiko']++;
                } else {
                    $deteksiRisk['Tidak Beresiko']++;
                }
            }
        } catch (\Exception $e) {
            Log::error('Error Fetching Deteksi Data for User ' . $userId . ': ' . $e->getMessage());
        }

        return [
            'deteksiCount' => $deteksiCount,
            'deteksiRisk' => $deteksiRisk,
        ];
    }

    private function getKonsultasiData($userId)
{
    $konsultasiCount = 0;
    $konsultasiPerMonthArray = array_fill(0, 12, 0);

    try {
        $konsultasiData = DB::connection('mongodb')
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

        $konsultasiDataArray = iterator_to_array($konsultasiData);

        foreach ($konsultasiDataArray as $data) {
            $monthIndex = $data['_id'] - 1;
            if ($monthIndex >= 0 && $monthIndex < 12) {
                $konsultasiPerMonthArray[$monthIndex] = $data['count'];
            }
        }

        $konsultasiCount = array_sum($konsultasiPerMonthArray);
    } catch (\Exception $e) {
        Log::error('Error Fetching Konsultasi Data for User ' . $userId . ': ' . $e->getMessage());
    }

    return [
        'konsultasiCount' => $konsultasiCount,
        'konsultasiPerMonth' => $konsultasiPerMonthArray,
    ];
}
}