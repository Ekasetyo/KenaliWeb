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

            $konsultasiData = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('konsultasis')
                ->aggregate([
                    [
                        '$match' => [
                            'user_id' => $userId,
                            'created_at' => [
                                '$gte' => new UTCDateTime($startTimestamp),
                                '$lte' => new UTCDateTime($endTimestamp),
                            ],
                        ],
                    ],
                    [
                        '$group' => [
                            '_id' => ['$dayOfMonth' => '$created_at'],
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

            foreach ($variables as $var) {
                $impact = DB::connection('mongodb')
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
                                '_id' => null,
                                'avg' => ['$avg' => "$$var"],
                            ],
                        ],
                    ]);
                $impactArray = iterator_to_array($impact);
                $impactValue = !empty($impactArray) ? $impactArray[0]['avg'] : 0;
                $variableImpact[$var] = $impactValue;
            }

            arsort($variableImpact);
            $topVariables = array_slice($variableImpact, 0, 5, true);
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