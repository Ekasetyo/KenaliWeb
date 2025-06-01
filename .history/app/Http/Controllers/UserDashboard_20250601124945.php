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
            'deteksisPerMonthArray' => array_fill(0, 12, 0),
            'konsultasiCount' => 0,
            'konsultasisPerMonthArray' => array_fill(0, 12, 0),
            'genderRisk' => ['Laki-laki' => 0, 'Perempuan' => 0],
            'totalMale' => 0,
            'totalFemale' => 0,
            'topVariables' => [],
            'averageAgeRiskStroke' => 0,
            'averageAgeNoStroke' => 0,
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
        $deteksisPerMonthArray = array_fill(0, 12, 0);

        try {
            $currentYear = date('Y');
            $startTimestamp = strtotime("$currentYear-01-01") * 1000;
            $endTimestamp = strtotime("$currentYear-12-31 23:59:59") * 1000;

            $deteksiData = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('hasil_deteksi')
                ->aggregate([
                    [
                        '$match' => [
                            'user_id' => $userId,
                            'created_at' => [
                                '$gte' => new UTCDateTime($startTimestamp),
                                '$lt' => new UTCDateTime($endTimestamp),
                            ],
                        ],
                    ],
                    [
                        '$addFields' => [
                            'created_at_date' => [
                                '$dateFromString' => [
                                    'dateString' => [
                                        '$concat' => [
                                            [
                                                '$substrCP' => ['$created_at', 0, 23]
                                            ],
                                            'Z'
                                        ]
                                    ],
                                    'format' => '%Y-%m-%dT%H:%M:%S.%LZ',
                                    'onError' => null,
                                    'onNull' => null,
                                ],
                            ],
                        ],
                    ],
                    [
                        '$group' => [
                            '_id' => ['$month' => '$created_at_date'],
                            'count' => ['$sum' => 1],
                            'risk' => ['$push' => '$prediction'],
                        ],
                    ],
                    ['$sort' => ['_id' => 1]],
                ]);

            $deteksiArray = iterator_to_array($deteksiData);
            foreach ($deteksiArray as $data) {
                $monthIndex = $data['_id'] - 1;
                if ($monthIndex >= 0 && $monthIndex < 12) {
                    $deteksisPerMonthArray[$monthIndex] = $data['count'];
                    foreach ($data['risk'] as $risk) {
                        $prediction = strtolower($risk ?? '');
                        if (strpos($prediction, 'beresiko') !== false) {
                            $deteksiRisk['Beresiko']++;
                        } else {
                            $deteksiRisk['Tidak Beresiko']++;
                        }
                    }
                }
            }
            $deteksiCount = array_sum($deteksisPerMonthArray);
        } catch (\Exception $e) {
            Log::error('Error Fetching Deteksi Data for User ' . $userId . ': ' . $e->getMessage());
        }

        return [
            'deteksiCount' => $deteksiCount,
            'deteksiRisk' => $deteksiRisk,
            'deteksisPerMonthArray' => $deteksisPerMonthArray,
        ];
    }

    private function getKonsultasiData($userId)
    {
        $konsultasiCount = 0;
        $konsultasisPerMonthArray = array_fill(0, 12, 0);

        try {
            $currentYear = date('Y');
            $startTimestamp = strtotime("$currentYear-01-01") * 1000;
            $endTimestamp = strtotime("$currentYear-12-31 23:59:59") * 1000;

            $konsultasiData = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('konsultasis')
                ->aggregate([
                    [
                        '$match' => [
                            'id_pengguna' => $userId,
                            'created_at' => [
                                '$gte' => new UTCDateTime($startTimestamp),
                                '$lt' => new UTCDateTime($endTimestamp),
                            ],
                        ],
                    ],
                    [
                        '$addFields' => [
                            'created_at_date' => [
                                '$dateFromString' => [
                                    'dateString' => '$created_at',
                                    'format' => '%Y-%m-%dT%H:%M:%S.%LZ',
                                    'onError' => null,
                                    'onNull' => null,
                                ],
                            ],
                        ],
                    ],
                    [
                        '$group' => [
                            '_id' => ['$month' => '$created_at_date'],
                            'count' => ['$sum' => 1],
                        ],
                    ],
                    ['$sort' => ['_id' => 1]],
                ]);

            $konsultasiArray = iterator_to_array($konsultasiData);
            foreach ($konsultasiArray as $data) {
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
            'konsultasisPerMonthArray' => $konsultasisPerMonthArray,
        ];
    }

    private function getStrokeData()
    {
        $genderRisk = ['Laki-laki' => 0, 'Perempuan' => 0];
        $totalMale = 0;
        $totalFemale = 0;
        $topVariables = [];
        $averageAgeRiskStroke = 0;
        $averageAgeNoStroke = 0;

        try {
            $sampleData = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('data_stroke')
                ->find([], ['limit' => 5]);
            $sampleDataArray = iterator_to_array($sampleData);
            Log::info('Sample Data from data_stroke:', $sampleDataArray);

            $strokeGenderData = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('data_stroke')
                ->aggregate([
                    ['$match' => ['stroke' => 1]],
                    ['$group' => ['_id' => '$sex', 'count' => ['$sum' => 1]]],
                ]);
            $strokeGenderArray = iterator_to_array($strokeGenderData);
            foreach ($strokeGenderArray as $data) {
                $gender = $data['_id'] == 1 ? 'Laki-laki' : 'Perempuan';
                $genderRisk[$gender] = $data['count'];
            }

            $totalGenderData = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('data_stroke')
                ->aggregate([
                    ['$group' => ['_id' => '$sex', 'total' => ['$sum' => 1]]],
                ]);
            $totalGenderArray = iterator_to_array($totalGenderData);
            foreach ($totalGenderArray as $data) {
                if ($data['_id'] == 1) $totalMale = $data['total'];
                else $totalFemale = $data['total'];
            }

            $totalStroke = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('data_stroke')
                ->count(['stroke' => 1]);
            Log::info('Total People with Stroke:', ['total' => $totalStroke]);

            $variables = [
                'hypertension' => ['label' => 'Hipertensi', 'condition' => ['$eq' => [1]]],
                'avg_glucose_level' => ['label' => 'Glukosa di atas 180', 'condition' => ['$gt' => 180]],
                'bmi' => ['label' => 'BMI di atas 25', 'condition' => ['$gt' => 25]],
                'ever_married' => ['label' => 'Status Pernikahan', 'condition' => ['$eq' => [1]]],
            ];
            $variableImpact = [];

            foreach ($variables as $var => $config) {
                $count = DB::connection('mongodb')
                    ->getMongoDB()
                    ->selectCollection('data_stroke')
                    ->count(['stroke' => 1, $var => $config['condition']]);
                $impactValue = $totalStroke > 0 ? ($count / $totalStroke) * 100 : 0;
                $variableImpact[$config['label']] = $impactValue;
            }

            arsort($variableImpact);
            $topVariables = array_slice($variableImpact, 0, 5, true);

            $ageData = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('data_stroke')
                ->aggregate([
                    [
                        '$group' => [
                            '_id' => '$stroke',
                            'avgAge' => ['$avg' => '$age']
                        ]
                    ]
                ]);
            $ageArray = iterator_to_array($ageData);
            foreach ($ageArray as $data) {
                if ($data['_id'] == 1) $averageAgeRiskStroke = round($data['avgAge']);
                else $averageAgeNoStroke = round($data['avgAge']);
            }
        } catch (\Exception $e) {
            Log::error('Error Fetching Stroke Data: ' . $e->getMessage());
        }

        Log::info('Processed Stroke Data:', [
            'genderRisk' => $genderRisk,
            'totalMale' => $totalMale,
            'totalFemale' => $totalFemale,
            'topVariables' => $topVariables,
            'averageAgeRiskStroke' => $averageAgeRiskStroke,
            'averageAgeNoStroke' => $averageAgeNoStroke,
        ]);

        return [
            'genderRisk' => $genderRisk,
            'totalMale' => $totalMale,
            'totalFemale' => $totalFemale,
            'topVariables' => $topVariables,
            'averageAgeRiskStroke' => $averageAgeRiskStroke,
            'averageAgeNoStroke' => $averageAgeNoStroke,
        ];
    }
}