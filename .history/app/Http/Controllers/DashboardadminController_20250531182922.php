<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Artikel;
use App\Models\Konsultasi;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use MongoDB\BSON\UTCDateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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
        $this->debugMongoConnection();

        // Ambil data untuk dashboard
        $userData = $this->getUserData();
        $artikelData = $this->getArtikelData();
        $deteksiData = $this->getDeteksiData();
        $konsultasiData = $this->getKonsultasiData();

        // Kirim ke view
        return view('admin.dashboard.index', array_merge(
            $userData,
            $artikelData,
            $deteksiData,
            $konsultasiData
        ));
    }

    private function debugMongoConnection()
    {
        try {
            $connection = DB::connection('mongodb');
            $databaseName = $connection->getMongoDB()->getDatabaseName();
            Log::info('MongoDB Connection Details:', [
                'host' => $connection->getConfig('host'),
                'port' => $connection->getConfig('port'),
                'database' => $databaseName,
            ]);

            $collections = $connection->getMongoDB()->listCollections();
            $collectionNames = [];
            foreach ($collections as $collection) {
                $collectionNames[] = $collection->getName();
            }
            Log::info('Available Collections in kenali:', $collectionNames);
        } catch (\Exception $e) {
            Log::error('MongoDB Connection Test Failed: ' . $e->getMessage());
        }
    }

    private function getUserData()
    {
        $userCount = 0;
        $usersPerMonthArray = array_fill(0, 12, 0);

        try {
            $userCount = User::count();
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
        } catch (\Exception $e) {
            Log::error('Error Fetching Users Data: ' . $e->getMessage());
        }

        return [
            'userCount' => $userCount,
            'usersPerMonthArray' => $usersPerMonthArray,
        ];
    }

    private function getArtikelData()
    {
        $artikelCount = 0;
        $artikelsPerMonthArray = array_fill(0, 12, 0);

        try {
            $artikelCount = Artikel::count();
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
        } catch (\Exception $e) {
            Log::error('Error Fetching Artikels Data: ' . $e->getMessage());
        }

        return [
            'artikelCount' => $artikelCount,
            'artikelsPerMonthArray' => $artikelsPerMonthArray,
        ];
    }

    private function getDeteksiData()
    {
        $deteksiCount = 0;
        $deteksisPerMonthArray = array_fill(0, 12, 0);

        try {
            // Ambil data mentah dari hasil_deteksi
            $dataCursor = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('hasil_deteksi')
                ->find([], ['limit' => 10]);
            $dataArray = iterator_to_array($dataCursor);
            Log::info('Raw Deteksi Data:', $dataArray);
            $deteksiCount = count($dataArray);

            // Ambil data deteksi per bulan (tahun 2025)
            $deteksisPerMonth = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('hasil_deteksi')
                ->aggregate([
                    [
                        // Konversi created_at dari string ke date
                        '$addFields' => [
                            'created_at_date' => [
                                '$dateFromString' => [
                                    'dateString' => '$created_at',
                                    'format' => '%Y-%m-%dT%H:%M:%S.%L', // Sesuaikan format tanpa Z
                                    'onError' => null,
                                    'onNull' => null,
                                ],
                            ],
                        ],
                    ],
                    [
                        // Debug: Log dokumen setelah konversi
                        '$addFields' => [
                            'debug_created_at_date' => '$created_at_date',
                        ],
                    ],
                    [
                        '$match' => [
                            'created_at_date' => [
                                '$gte' => new UTCDateTime(strtotime('2025-01-01') * 1000),
                                '$lt' => new UTCDateTime(strtotime('2026-01-01') * 1000),
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
            $deteksisPerMonthArrayRaw = iterator_to_array($deteksisPerMonth);
            Log::info('Deteksis Per Month Raw Result:', $deteksisPerMonthArrayRaw);

            foreach ($deteksisPerMonthArrayRaw as $data) {
                $monthIndex = $data['_id'] - 1;
                if ($monthIndex >= 0 && $monthIndex < 12) {
                    $deteksisPerMonthArray[$monthIndex] = $data['count'];
                }
            }
        } catch (\Exception $e) {
            Log::error('Error Fetching Deteksi Data: ' . $e->getMessage());
        }

        return [
            'deteksiCount' => $deteksiCount,
            'deteksisPerMonthArray' => $deteksisPerMonthArray,
        ];
    }

    private function getKonsultasiData()
    {
        $konsultasiCount = 0;
        $konsultasisPerMonthArray = array_fill(0, 12, 0);

        try {
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
        } catch (\Exception $e) {
            Log::error('Error Fetching Konsultasi Data: ' . $e->getMessage());
        }

        return [
            'konsultasiCount' => $konsultasiCount,
            'konsultasisPerMonthArray' => $konsultasisPerMonthArray,
        ];
    }
}