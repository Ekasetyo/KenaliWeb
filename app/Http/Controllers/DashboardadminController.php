<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Artikel;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class DashboardAdminController extends Controller
{
    public function index()
    {
        // Cek akses
        if (!Session::has('user') || Session::get('user')['status'] !== 'admin') {
            Alert::error('Akses Ditolak', 'Anda tidak memiliki akses');
            return redirect('/login');
        }

        // Ambil jumlah pengguna dan artikel
        $userCount = User::count();
        $artikelCount = Artikel::count();

        // Ambil jumlah pengguna per bulan
        $usersPerMonth = User::raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$group' => [
                        '_id' => ['$month' => '$created_at'], // Pastikan `created_at` adalah Date
                        'count' => ['$sum' => 1]
                    ]
                ],
                [
                    '$sort' => ['_id' => 1]
                ]
            ]);
        });

        // Ambil jumlah artikel per bulan
        $artikelsPerMonth = Artikel::raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$group' => [
                        '_id' => ['$month' => '$created_at'], // Pastikan `created_at` adalah Date
                        'count' => ['$sum' => 1]
                    ]
                ],
                [
                    '$sort' => ['_id' => 1]
                ]
            ]);
        });

        // Ubah hasil ke array
        $usersPerMonthArray = array_fill(0, 12, 0);
        foreach ($usersPerMonth as $data) {
            $usersPerMonthArray[$data['_id'] - 1] = $data['count'];
        }

        $artikelsPerMonthArray = array_fill(0, 12, 0);
        foreach ($artikelsPerMonth as $data) {
            $artikelsPerMonthArray[$data['_id'] - 1] = $data['count'];
        }

        return view('admin.dashboard.index', compact('userCount', 'artikelCount', 'usersPerMonthArray', 'artikelsPerMonthArray'));
    }
}