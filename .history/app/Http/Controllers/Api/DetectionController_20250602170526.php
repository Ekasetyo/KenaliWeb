
<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DetectionController extends Controller
{
    public function getDetectionsPerMonth(Request $request)
    {
        // Validasi input
        $request->validate([
            'user_id' => 'required|string',
        ]);

        $userId = $request->input('user_id');

        try {
            // Inisialisasi array untuk menyimpan jumlah deteksi per bulan (1-12)
            $deteksisPerMonthArray = array_fill(1, 12, 0);

            // Ambil data deteksi per bulan dari MongoDB
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
                                    ['$substrCP' => ['$created_at', 0, 23]],
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
                $monthIndex = $data['_id'];
                if ($monthIndex >= 1 && $monthIndex <= 12) {
                    $deteksisPerMonthArray[$monthIndex] = $data['count'];
                }
            }

            return response()->json([
                'status' => 'success',
                'data' => $deteksisPerMonthArray,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error Fetching Deteksi Data for User ' . $userId . ': ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data deteksi: ' . $e->getMessage(),
            ], 500);
        }
    }
}