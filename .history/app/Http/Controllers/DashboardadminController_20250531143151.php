<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Artikel;
use App\Models\Deteksi;
use App\Models\Konsultasi;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use MongoDB\BSON\UTCDateTime;
use Illuminate\Support\Facades\Log;

class DashboardAdminController extends Controller
{
    public function index()
    {
        // Cek akses
        if (!Session::has('user') || Session::get('user')['status'] !== 'admin') {
            Alert::error('Akses Ditolak', 'Anda tidak memiliki akses');
            return redirect('/login');
        }

        // Debug koneksi MongoDB
        try {
            $connection = Deteksi::getMongoDB();
            $connectionDetails = $connection->getManager()->getConnections()[0];
            Log::info('MongoDB Connection Details:', [
                'host' => $connectionDetails->getHost(),
                'port' => $connectionDetails->getPort(),
                'database' => $connectionDetails->getDatabaseName(),
            ]);
        } catch (\Exception $e) {
            Log::error('MongoDB Connection Test Failed: ' . $e->getMessage());
        }

        // Debug data mentah
        try {
            $rawData = Deteksi::raw(function ($collection) {
                return $collection->find([]);
            });
            Log::info('Raw Deteksi Data:', $rawData->toArray());
        } catch (\Exception $e) {
            Log::error('Error Fetching Raw Deteksi Data: ' . $e->getMessage());
        }

        // Debug pipeline langkah demi langkah
        try {
            $deteksiDebug = Deteksi::raw(function ($collection) {
                return $collection->aggregate([
                    [
                        '$addFields' => [
                            'created_at_converted' => [
                                '$dateFromString' => [
                                    'dateString' => ['$substr' => ['$created_at', 0, 23]],
                                    'format' => '%Y-%m-%dT%H:%M:%S.%L',
                                    'timezone' => 'Asia/Jakarta'
                                ]
                            ]
                        ]
                    ],
                    [
                        '$project' => [
                            'created_at' => 1,
                            'created_at_converted' => 1
                        ]
                    ]
                ]);
            });
            Log::info('Deteksi Debug - Converted Dates:', $deteksiDebug->toArray());
        } catch (\Exception $e) {
            Log::error('Pipeline Debug Error: ' . $e->getMessage());
        }

        // Ambil total pengguna dan artikel
        $userCount = User::count();
        $artikelCount = Artikel::count();

        // Ambil jumlah deteksi bulan ini
        $deteksiResult = Deteksi::raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$addFields' => [
                        'created_at_converted' => [
                            '$dateFromString' => [
                                'dateString' => ['$substr' => ['$created_at', 0, 23]],
                                'format' => '%Y-%m-%dT%H:%M:%S.%L',
                                'timezone' => 'Asia/Jakarta'
                            ]
                        ]
                    ]
                ],
                [
                    '$match' => [
                        'created_at_converted' => [
                            '$gte' => new UTCDateTime(strtotime('2025-05-01 00:00:00') * 1000),
                            '$lt' => new UTCDateTime(strtotime('2025-05-31 23:59:59') * 1000 + 1000),
                        ],
                    ],
                ],
                [
                    '$count' => 'total',
                ],
            ]);
        });
        $deteksiCount = $deteksiResult->isEmpty() ? 0 : $deteksiResult[0]['total'];
        Log::info('Deteksi Count Raw Result:', $deteksiResult->toArray());

        // Ambil jumlah konsultasi bulan ini
        $konsultasiResult = Konsultasi::raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$match' => [
                        'created_at' => [
                            '$gte' => new UTCDateTime(strtotime('2025-05-01 00:00:00') * 1000),
                            '$lt' => new UTCDateTime(strtotime('2025-05-31 23:59:59') * 1000 + 1000),
                        ],
                    ],
                ],
                [
                    '$count' => 'total',
                ],
            ]);
        });
        $konsultasiCount = $konsultasiResult->isEmpty() ? 0 : $konsultasiResult[0]['total'];

        // Inisialisasi array untuk menyimpan jumlah per bulan
        $usersPerMonthArray = array_fill(0, 12, 0);
        $artikelsPerMonthArray = array_fill(0, 12, 0);
        $deteksisPerMonthArray = array_fill(0, 12, 0);
        $konsultasisPerMonthArray = array_fill(0, 12, 0);

        // Ambil data pengguna per bulan (tahun 2025)
        $usersPerMonth = User::raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$match' => [
                        'created_at' => [
                            '$gte' => new UTCDateTime(strtotime('2025-01-01') * 1000),
                            '$lt' => new UTCDateTime(strtotime('2026-01-01') * 1000),
                        ],
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
        });

        foreach ($usersPerMonth as $data) {
            $monthIndex = $data['_id'] - 1;
            if ($monthIndex >= 0 && $monthIndex < 12) {
                $usersPerMonthArray[$monthIndex] = $data['count'];
            }
        }

        // Ambil data artikel per bulan (tahun 2025)
        $artikelsPerMonth = Artikel::raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$match' => [
                        'created_at' => [
                            '$gte' => new UTCDateTime(strtotime('2025-01-01') * 1000),
                            '$lt' => new UTCDateTime(strtotime('2026-01-01') * 1000),
                        ],
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
        });

        foreach ($artikelsPerMonth as $data) {
            $monthIndex = $data['_id'] - 1;
            if ($monthIndex >= 0 && $monthIndex < 12) {
                $artikelsPerMonthArray[$monthIndex] = $data['count'];
            }
        }

        // Ambil data deteksi per bulan (tahun 2025)
        $deteksisPerMonth = Deteksi::raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$addFields' => [
                        'created_at_converted' => [
                            '$dateFromString' => [
                                'dateString' => ['$substr' => ['$created_at', 0, 23]],
                                'format' => '%Y-%m-%dT%H:%M:%S.%L',
                                'timezone' => 'Asia/Jakarta'
                            ]
                        ]
                    ]
                ],
                [
                    '$match' => [
                        'created_at_converted' => [
                            '$gte' => new UTCDateTime(strtotime('2025-01-01') * 1000),
                            '$lt' => new UTCDateTime(strtotime('2026-01-01') * 1000),
                        ],
                    ],
                ],
                [
                    '$group' => [
                        '_id' => ['$month' => '$created_at_converted'],
                        'count' => ['$sum' => 1],
                    ],
                ],
                ['$sort' => ['_id' => 1]],
            ]);
        });

        Log::info('Deteksis Per Month Raw Result:', $deteksisPerMonth->toArray());

        foreach ($deteksisPerMonth as $data) {
            $monthIndex = $data['_id'] - 1;
            if ($monthIndex >= 0 && $monthIndex < 12) {
                $deteksisPerMonthArray[$monthIndex] = $data['count'];
            }
        }

        // Ambil data konsultasi per bulan (tahun 2025)
        $konsultasisPerMonth = Konsultasi::raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$match' => [
                        'created_at' => [
                            '$gte' => new UTCDateTime(strtotime('2025-01-01') * 1000),
                            '$lt' => new UTCDateTime(strtotime('2026-01-01') * 1000),
                        ],
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
        });

        foreach ($konsultasisPerMonth as $data) {
            $monthIndex = $data['_id'] - 1;
            if ($monthIndex >= 0 && $monthIndex < 12) {
                $konsultasisPerMonthArray[$monthIndex] = $data['count'];
            }
        }

        // Kirim ke view
        return view('admin.dashboard.index', compact(
            'userCount',
            'artikelCount',
            'deteksiCount',
            'konsultasiCount',
            'usersPerMonthArray',
            'artikelsPerMonthArray',
            'deteksisPerMonthArray',
            'konsultasisPerMonthArray'
        ));
    }
}