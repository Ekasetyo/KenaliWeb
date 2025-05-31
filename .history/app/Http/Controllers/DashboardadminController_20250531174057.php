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
        try {
            $connection = DB::connection('mongodb');
            $databaseName = $connection->getMongoDB()->getDatabaseName();
            Log::info('MongoDB Connection Details:', [
                'host' => $connection->getConfig('host'),
                'port' => $connection->getConfig('port'),
                'database' => $databaseName,
            ]);

            // Debug daftar koleksi di database
            $collections = $connection->getMongoDB()->listCollections();
            $collectionNames = [];
            foreach ($collections as $collection) {
                $collectionNames[] = $collection->getName();
            }
            Log::info('Available Collections in kenali:', $collectionNames);
        } catch (\Exception $e) {
            Log::error('MongoDB Connection Test Failed: ' . $e->getMessage());
        }

        // Ambil data mentah dari hasil_deteksi
        try {
            Log::info('Attempting to fetch data from hasil_deteksi collection');
            $dataCursor = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('hasil_deteksi')
                ->find([], ['limit' => 10]); // Ambil 10 dokumen pertama
            $dataArray = iterator_to_array($dataCursor);
            Log::info('Raw Deteksi Data:', $dataArray);
        } catch (\Exception $e) {
            Log::error('Error Fetching Raw Deteksi Data: ' . $e->getMessage());
        }

        // Ambil total pengguna dan artikel
        $userCount = User::count();
        $artikelCount = Artikel::count();

        // Ambil jumlah deteksi
        $deteksiCount = count($dataArray);
        Log::info('Deteksi Count:', ['total' => $deteksiCount]);

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
        $konsultasisPerMonthArray = array_fill(0, 12, 0);

        // Inisialisasi array untuk deteksi per user_id
        $deteksisPerUserArray = [];

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

        // Ambil data deteksi per user_id
        $deteksisPerUser = DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('hasil_deteksi')
            ->aggregate([
                [
                    '$group' => [
                        '_id' => '$user_id',
                        'count' => ['$sum' => 1],
                    ],
                ],
                ['$sort' => ['_id' => 1]],
            ]);
        $deteksisPerUserArray = iterator_to_array($deteksisPerUser);
        Log::info('Deteksis Per User Raw Result:', $deteksisPerUserArray);

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
            'deteksisPerUserArray',
            'konsultasisPerMonthArray'
        ));
    }
}