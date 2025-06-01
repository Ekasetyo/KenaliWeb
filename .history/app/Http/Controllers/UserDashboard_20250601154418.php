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
            'genderCounts' => ['Laki-laki' => 0, 'Perempuan' => 0],
        ];

        // Ambil data untuk dashboard
        $deteksiData = $this->getDeteksiData($userId);
        $konsultasiData = $this->getKonsultasiData($userId);
        $strokeData = $this->getStrokeData();

        // Gabungkan data dengan default
        $data = array_merge($data, $deteksiData, $konsultasiData, $strokeData);

        Log::info('Final Dashboard Data:', $data);

        return view('user.dashboard.index', $data);
    }

    private function getDeteksiData($userId)
    {
        $deteksiCount = 0;
        $deteksisPerMonthArray = array_fill(0, 12, 0);

        try {
            // Ambil data deteksi per bulan
            $deteksisPerMonth = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('hasil_deteksi')
                ->aggregate([
                    [
                        '$match' => [
                            'user_id' => (string)$userId,
                        ],
                    ],
                    [
                        // Potong created_at untuk mengambil hanya 3 digit milidetik dan tambahkan Z
                        '$addFields' => [
                            'created_at_trimmed' => [
                                '$concat' => [
                                    ['$substrCP' => ['$created_at', 0, 23]], // Ambil hingga 3 digit milidetik
                                    'Z'
                                ]
                            ]
                        ],
                    ],
                    [
                        // Konversi created_at_trimmed ke tanggal
                        '$addFields' => [
                            'created_at_date' => [
                                '$dateFromString' => [
                                    'dateString' => '$created_at_trimmed',
                                    'format' => '%Y-%m-%dT%H:%M:%S.%LZ',
                                    'onError' => null,
                                    'onNull' => null,
                                ],
                            ],
                        ],
                    ],
                    [
                        // Ambil data deteksi per bulan
                        '$group' => [
                            '_id' => ['$month' => '$created_at_date'],
                            'count' => ['$sum' => 1],
                        ],
                    ],
                    ['$sort' => ['_id' => 1]],
                ]);

            $deteksisPerMonthArrayRaw = iterator_to_array($deteksisPerMonth);
            Log::info('Deteksis Per Month Raw Result for User ' . $userId . ':', $deteksisPerMonthArrayRaw);

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

     private function getStrokeData()
    {
        $data = DB::connection('mongodb')->selectCollection('data_stroke')->find([]);

        $genderCounts = ['Laki-laki' => 0, 'Perempuan' => 0];

        foreach ($data as $item) {
            // Hitung berdasarkan jenis kelamin
            if ($item->sex == 1) {
                $genderCounts['Laki-laki']++;
            } else {
                $genderCounts['Perempuan']++;
            }
        }

        return [
            'genderCounts' => $genderCounts,
        ];
    }
}
