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

        // Ambil semua data
        $deteksiData = $this->getDeteksiData($userId);
        $konsultasiData = $this->getKonsultasiData($userId);
        $strokeData = $this->getStrokeData();
        $ageData = $this->getAgeData();
        $topFactors = $this->getTopFactors();

        return view('user.dashboard.index', array_merge(
            $deteksiData,
            $konsultasiData,
            $strokeData,
            ['ageData' => $ageData],
            ['topFactors' => $topFactors]
        ));
    }

    private function getDeteksiData($userId)
    {
        $deteksiCount = 0;
        $deteksiRisk = ['Beresiko' => 0, 'Tidak Beresiko' => 0];
        $deteksisPerMonthArray = array_fill(0, 12, 0);

        try {
            $currentYear = date('Y');
            $startDate = new UTCDateTime(strtotime("$currentYear-01-01") * 1000);
            $endDate = new UTCDateTime(strtotime("$currentYear-12-31 23:59:59") * 1000);

            $pipeline = [
                [
                    '$match' => [
                        'user_id' => $userId,
                        'created_at' => [
                            '$gte' => $startDate,
                            '$lt' => $endDate
                        ]
                    ]
                ],
                [
                    '$addFields' => [
                        'month' => ['$month' => ['$dateFromString' => [
                            'dateString' => '$created_at',
                            'format' => '%Y-%m-%dT%H:%M:%S.%LZ'
                        ]]]
                    ]
                ],
                [
                    '$group' => [
                        '_id' => '$month',
                        'count' => ['$sum' => 1],
                        'risiko' => ['$push' => '$prediction']
                    ]
                ],
                ['$sort' => ['_id' => 1]]
            ];

            $result = DB::connection('mongodb')
                ->getMongodb()
                ->collection('hasil_deteksi')
                ->aggregate($pipeline);

            foreach ($result as $data) {
                $monthIndex = $data['_id'] - 1;
                if ($monthIndex >= 0 && $monthIndex < 12) {
                    $deteksisPerMonthArray[$monthIndex] = $data['count'];
                    foreach ($data['risiko'] as $prediksi) {
                        if (strpos(strtolower($prediksi), 'beresiko') !== false) {
                            $deteksiRisk['Beresiko']++;
                        } else {
                            $deteksiRisk['Tidak Beresiko']++;
                        }
                    }
                }
            }

            $deteksiCount = array_sum($deteksisPerMonthArray);

        } catch (\Exception $e) {
            Log::error('Error mengambil data deteksi: '.$e->getMessage());
        }

        return [
            'deteksiCount' => $deteksiCount,
            'deteksiRisk' => $deteksiRisk,
            'deteksisPerMonthArray' => $deteksisPerMonthArray
        ];
    }

    private function getKonsultasiData($userId)
    {
        $konsultasiCount = 0;
        $konsultasisPerMonthArray = array_fill(0, 12, 0);

        try {
            $currentYear = date('Y');
            $startDate = new UTCDateTime(strtotime("$currentYear-01-01") * 1000);
            $endDate = new UTCDateTime(strtotime("$currentYear-12-31 23:59:59") * 1000);

            $pipeline = [
                [
                    '$match' => [
                        'id_pengguna' => $userId,
                        'created_at' => [
                            '$gte' => $startDate,
                            '$lt' => $endDate
                        ]
                    ]
                ],
                [
                    '$addFields' => [
                        'month' => ['$month' => ['$dateFromString' => [
                            'dateString' => '$created_at',
                            'format' => '%Y-%m-%dT%H:%M:%S.%LZ'
                        ]]]
                    ]
                ],
                [
                    '$group' => [
                        '_id' => '$month',
                        'count' => ['$sum' => 1]
                    ]
                ],
                ['$sort' => ['_id' => 1]]
            ];

            $result = DB::connection('mongodb')
                ->collection('konsultasis')
                ->aggregate($pipeline);

            foreach ($result as $data) {
                $monthIndex = $data['_id'] - 1;
                if ($monthIndex >= 0 && $monthIndex < 12) {
                    $konsultasisPerMonthArray[$monthIndex] = $data['count'];
                }
            }

            $konsultasiCount = array_sum($konsultasisPerMonthArray);

        } catch (\Exception $e) {
            Log::error('Error mengambil data konsultasi: '.$e->getMessage());
        }

        return [
            'konsultasiCount' => $konsultasiCount,
            'konsultasisPerMonthArray' => $konsultasisPerMonthArray
        ];
    }

    private function getStrokeData()
    {
        $genderData = [
            'Laki-laki' => ['stroke' => 0, 'no_stroke' => 0],
            'Perempuan' => ['stroke' => 0, 'no_stroke' => 0]
        ];

        try {
            $result = DB::connection('mongodb')
                ->collection('data_stroke')
                ->aggregate([
                    [
                        '$group' => [
                            '_id' => [
                                'sex' => '$sex',
                                'stroke' => '$stroke'
                            ],
                            'count' => ['$sum' => 1]
                        ]
                    ]
                ]);

            foreach ($result as $data) {
                $gender = $data['_id']['sex'] == 1 ? 'Laki-laki' : 'Perempuan';
                $key = $data['_id']['stroke'] == 1 ? 'stroke' : 'no_stroke';
                $genderData[$gender][$key] = $data['count'];
            }

        } catch (\Exception $e) {
            Log::error('Error mengambil data stroke: '.$e->getMessage());
        }

        return [
            'genderData' => $genderData
        ];
    }

    private function getAgeData()
    {
        $ageData = [
            'stroke' => 0,
            'no_stroke' => 0
        ];

        try {
            $result = DB::connection('mongodb')
                ->collection('data_stroke')
                ->aggregate([
                    [
                        '$group' => [
                            '_id' => '$stroke',
                            'avg_age' => ['$avg' => '$age'],
                            'count' => ['$sum' => 1]
                        ]
                    ]
                ]);

            foreach ($result as $data) {
                $key = $data['_id'] == 1 ? 'stroke' : 'no_stroke';
                $ageData[$key] = round($data['avg_age']);
            }

        } catch (\Exception $e) {
            Log::error('Error mengambil data usia: '.$e->getMessage());
        }

        return $ageData;
    }

    private function getTopFactors()
    {
        $factors = [];

        try {
            $totalStroke = DB::connection('mongodb')
                ->collection('data_stroke')
                ->where('stroke', 1)
                ->count();

            if ($totalStroke > 0) {
                $factorDefinitions = [
                    'hypertension' => ['$eq' => 1],
                    'heart_disease' => ['$eq' => 1],
                    'avg_glucose_level' => ['$gt' => 180],
                    'bmi' => ['$gt' => 25],
                    'ever_married' => ['$eq' => 1],
                    'smoking_status' => ['$eq' => 1],
                    'age' => ['$gt' => 50]
                ];

                foreach ($factorDefinitions as $factor => $condition) {
                    $count = DB::connection('mongodb')
                        ->collection('data_stroke')
                        ->where('stroke', 1)
                        ->where($factor, $condition)
                        ->count();

                    $percentage = round(($count / $totalStroke) * 100, 2);
                    $factors[$this->getFactorName($factor)] = $percentage;
                }

                arsort($factors);
                $factors = array_slice($factors, 0, 5, true);
            }

        } catch (\Exception $e) {
            Log::error('Error menghitung faktor stroke: '.$e->getMessage());
        }

        return $factors;
    }

    private function getFactorName($factor)
    {
        $names = [
            'hypertension' => 'Hipertensi',
            'heart_disease' => 'Penyakit Jantung',
            'avg_glucose_level' => 'Glukosa > 180',
            'bmi' => 'BMI > 25',
            'ever_married' => 'Pernah Menikah',
            'smoking_status' => 'Merokok',
            'age' => 'Usia > 50'
        ];

        return $names[$factor] ?? $factor;
    }
}