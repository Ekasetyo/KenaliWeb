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
            'genderRisk' => ['Laki-laki' => 0, 'Perempuan' => 0],
            'topVariables' => [],
        ];

        // Ambil data untuk dashboard
        $deteksiData = $this->getDeteksiData($userId);
        $konsultasiData = $this->getKonsultasiData($userId);
        $strokeData = $this->getStrokeData();

        // Gabungkan data dengan default
        $data = array_merge($data, $deteksiData ?? [], $konsultasiData ?? [], $strokeData ?? []);

        Log::info('Final Dashboard Data:', $data);

        return view('user.dashboard.index', $data);
    }

    private function getDeteksiData($userId)
    {
        $deteksiCount = 0;
        $deteksiRisk = ['Beresiko' => 0, 'Tidak Beresiko' => 0];

        try {
            // Tentukan rentang waktu 1 bulan terakhir berdasarkan tanggal saat ini (Juni 2025)
            $currentDate = new \DateTime('2025-06-01');
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

        Log::info('Processed Deteksi Data for User ' . $userId . ':', [
            'deteksiCount' => $deteksiCount,
            'deteksiRisk' => $deteksiRisk,
        ]);

        return [
            'deteksiCount' => $deteksiCount,
            'deteksiRisk' => $deteksiRisk,
        ];
    }

    private function getKonsultasiData($userId)
    {
        $konsultasiCount = 0;
        $konsultasiPerDay = array_fill(0, 31, 0);

        try {
            // Tentukan rentang waktu 1 bulan terakhir berdasarkan tanggal saat ini (Juni 2025)
            $currentDate = new \DateTime('2025-06-01');
            $startDate = $currentDate->modify('first day of this month')->setTime(0, 0, 0);
            $endDate = $currentDate->modify('last day of this month')->setTime(23, 59, 59);

            $startTimestamp = $startDate->getTimestamp() * 1000;
            $endTimestamp = $endDate->getTimestamp() * 1000;

            Log::info('Konsultasi Date Range:', [
                'start' => $startDate->format('Y-m-d H:i:s'),
                'end' => $endDate->format('Y-m-d H:i:s'),
                'startTimestamp' => $startTimestamp,
                'endTimestamp' => $endTimestamp,
            ]);

            // Debug: Ambil semua data konsultasi untuk user ini (tanpa filter waktu)
            $allKonsultasi = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('konsultasis')
                ->find(['user_id' => $userId], ['limit' => 10]);
            $allKonsultasiArray = iterator_to_array($allKonsultasi);
            Log::info('All Konsultasi Data for User ' . $userId . ':', $allKonsultasiArray);

            // Query agregasi untuk konsultasi per hari, dengan konversi created_at
            $konsultasiData = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('konsultasis')
                ->aggregate([
                    [
                        '$match' => [
                            'user_id' => $userId,
                        ],
                    ],
                    [
                        '$addFields' => [
                            'created_at_trimmed' => [
                                '$cond' => [
                                    'if' => ['$isString' => '$created_at'],
                                    'then' => [
                                        '$concat' => [
                                            ['$substrCP' => ['$created_at', 0, 23]],
                                            'Z'
                                        ]
                                    ],
                                    'else' => '$created_at'
                                ]
                            ]
                        ],
                    ],
                    [
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
                        '$match' => [
                            'created_at_date' => [
                                '$gte' => new UTCDateTime($startTimestamp),
                                '$lte' => new UTCDateTime($endTimestamp),
                            ],
                        ],
                    ],
                    [
                        '$group' => [
                            '_id' => ['$dayOfMonth' => '$created_at_date'],
                            'count' => ['$sum' => 1],
                        ],
                    ],
                    ['$sort' => ['_id' => 1]],
                ]);
            $konsultasiDataArray = iterator_to_array($konsultasiData);
            Log::info('Raw Konsultasi Data for User ' . $userId . ':', $konsultasiDataArray);

            foreach ($konsultasiDataArray as $data) {
                $dayIndex = $data['_id'] - 1;
                if ($dayIndex >= 0 && $dayIndex < 31) {
                    $konsultasiPerDay[$dayIndex] = $data['count'];
                }
            }

            $konsultasiCount = array_sum($konsultasiPerDay);
        } catch (\Exception $e) {
            Log::error('Error Fetching Konsultasi Data for User ' . $userId . ': ' . $e->getMessage());
        }

        Log::info('Processed Konsultasi Data for User ' . $userId . ':', [
            'konsultasiCount' => $konsultasiCount,
            'konsultasiPerDay' => $konsultasiPerDay,
        ]);

        return [
            'konsultasiCount' => $konsultasiCount,
            'konsultasiPerDay' => $konsultasiPerDay,
        ];
    }

    private function getStrokeData()
    {
        $genderRisk = ['Laki-laki' => 0, 'Perempuan' => 0];
        $topVariables = [];

        try {
            // Debug: Ambil beberapa data mentah dari data_stroke
            $sampleData = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('data_stroke')
                ->find([], ['limit' => 5]);
            $sampleDataArray = iterator_to_array($sampleData);
            Log::info('Sample Data from data_stroke:', $sampleDataArray);

            // Analisis jenis kelamin yang beresiko stroke
            $strokeGenderData = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('data_stroke')
                ->aggregate([
                    [
                        '$match' => [
                            'stroke' => 1,
                        ],
                    ],
                    [
                        '$group' => [
                            '_id' => '$sex',
                            'count' => ['$sum' => 1],
                        ],
                    ],
                ]);
            $strokeGenderArray = iterator_to_array($strokeGenderData);
            Log::info('Stroke Gender Raw Result:', $strokeGenderArray);

            foreach ($strokeGenderArray as $data) {
                $gender = $data['_id'] == 1 ? 'Laki-laki' : 'Perempuan';
                $genderRisk[$gender] = $data['count'];
            }

            // Analisis top 5 variabel
            $variables = ['age', 'hypertension', 'heart_disease', 'avg_glucose_level', 'bmi'];
            $variableImpact = [];

            // Hitung total orang dengan stroke = 1
            $totalStroke = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('data_stroke')
                ->count(['stroke' => 1]);
            Log::info('Total People with Stroke:', ['total' => $totalStroke]);

            foreach ($variables as $var) {
                if (in_array($var, ['hypertension', 'heart_disease'])) {
                    // Untuk variabel biner: hitung proporsi yang bernilai 1 pada stroke = 1
                    $count = DB::connection('mongodb')
                        ->getMongoDB()
                        ->selectCollection('data_stroke')
                        ->count([
                            'stroke' => 1,
                            $var => 1,
                        ]);
                    $impactValue = $totalStroke > 0 ? ($count / $totalStroke) * 100 : 0; // Persentase
                    $variableImpact[$var] = $impactValue;
                } else {
                    // Untuk variabel kontinu: gunakan binning untuk menghitung proporsi pada rentang tertentu
                    $ranges = [];
                    if ($var === 'age') {
                        $ranges = [
                            ['label' => 'age_above_60', 'condition' => ['$gt' => 60]],
                        ];
                    } elseif ($var === 'avg_glucose_level') {
                        $ranges = [
                            ['label' => 'glucose_above_140', 'condition' => ['$gt' => 140]], // Tinggi (diabetes)
                        ];
                    } elseif ($var === 'bmi') {
                        $ranges = [
                            ['label' => 'bmi_above_30', 'condition' => ['$gt' => 30]], // Obesitas
                        ];
                    }

                    $impactValue = 0;
                    foreach ($ranges as $range) {
                        $count = DB::connection('mongodb')
                            ->getMongoDB()
                            ->selectCollection('data_stroke')
                            ->count([
                                'stroke' => 1,
                                $var => $range['condition'],
                            ]);
                        $impactValue = $totalStroke > 0 ? ($count / $totalStroke) * 100 : 0; // Persentase
                        $variableImpact[$range['label']] = $impactValue;
                    }
                }
            }

            // Urutkan berdasarkan impactValue
            arsort($variableImpact);
            $topVariables = array_slice($variableImpact, 0, 5, true);

            Log::info('Variable Impact:', $variableImpact);
        } catch (\Exception $e) {
            Log::error('Error Fetching Stroke Data: ' . $e->getMessage());
        }

        Log::info('Processed Stroke Data:', [
            'genderRisk' => $genderRisk,
            'topVariables' => $topVariables,
        ]);

        return [
            'genderRisk' => $genderRisk,
            'topVariables' => $topVariables,
        ];
    }
}