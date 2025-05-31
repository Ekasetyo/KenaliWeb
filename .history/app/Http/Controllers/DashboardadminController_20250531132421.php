<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Artikel;
use App\Models\Deteksi;
use App\Models\Konsultasi;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use MongoDB\BSON\UTCDateTime;

class DashboardAdminController extends Controller
{
    public function index()
    {
        // Cek akses
        if (!Session::has('user') || Session::get('user')['status'] !== 'admin') {
            Alert::error('Akses Ditolak', 'Anda tidak memiliki akses');
            return redirect('/login');
        }

        // Ambil total pengguna dan artikel
        $userCount = User::count();
        $artikelCount = Artikel::count();

        // Ambil jumlah deteksi bulan ini
        $deteksiResult = Deteksi::raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$match' => [
                        'created_at' => [
                            '$gte' => new UTCDateTime(strtotime(date('Y-m-01')) * 1000),
                            '$lt' => new UTCDateTime(strtotime(date('Y-m-t 23:59:59')) * 1000 + 1000),
                        ],
                    ],
                ],
                [
                    '$count' => 'total',
                ],
            ]);
        });
        $deteksiCount = $deteksiResult->isEmpty() ? 0 : $deteksiResult[0]['total'];

        // Ambil jumlah konsultasi bulan ini
        $konsultasiResult = Konsultasi::raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$match' => [
                        'created_at' => [
                            '$gte' => new UTCDateTime(strtotime(date('Y-m-01')) * 1000),
                            '$lt' => new UTCDateTime(strtotime(date('Y-m-t 23:59:59')) * 1000 + 1000),
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