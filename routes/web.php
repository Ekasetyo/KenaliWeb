<?php

use App\Http\Controllers\DashboardadminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DatauserController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\PrediksiController;
use App\Http\Controllers\AdminDataPrediksi;
use App\Http\Controllers\AdminVisualisasi;
use App\Http\Controllers\AdminLaporan;


// Landing page
Route::get('/', function () {
    return view('landing-page.landing-page');
});

// Login & Register
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', function () {
    return view('login-register.register');
});

// Dashboard umum (jika ada)
Route::get('/dashboard', function () {
    if (session('user')) {
        return view('dashboard-form.dashboard');
    }
    return redirect('/login');
})->name('user.dashboard');

// ================= ADMIN ROUTES =================
Route::middleware(['login.session', 'admin'])->prefix('admin')->controller(AdminController::class)->group(function () {
    Route::get('/dashboard', [DashboardadminController::class, 'index'])->name('admin.dashboard');
    Route::get('/user', [DatauserController::class, 'index'])->name('admin.user.index');
    Route::post('/user', [DatauserController::class, 'store'])->name('admin.user.store');
    Route::delete('/user/{id}', [DatauserController::class, 'destroy'])->name('admin.user.destroy');
    Route::get('/user/edit/{id}', [DatauserController::class, 'edit'])->name('admin.user.edit');
    Route::put('/user/update/{id}', [DatauserController::class, 'update'])->name('admin.user.update');

    Route::get('/artikel', [ArtikelController::class, 'index'])->name('admin.artikel.index');
    Route::post('/artikel', [ArtikelController::class, 'store'])->name('admin.artikel.store');
    Route::get('/data-artikel/edit/{id}', [ArtikelController::class, 'edit'])->name('admin.artikel.edit');
    Route::put('/data-artikel/update/{id}', [ArtikelController::class, 'update'])->name('admin.artikel.update');
    Route::delete('/data-artikel/{id}', [ArtikelController::class, 'destroy'])->name('admin.artikel.destroy');

    Route::get('/hasil-prediksi', [AdminDataPrediksi::class, 'dataPrediksi'])->name('admin.hasil-prediksi');
    Route::get('/visualisasi', [AdminVisualisasi::class, 'visualisasi'])->name('admin.visualisasi');
    Route::get('/laporan', [AdminLaporan::class, 'laporan'])->name('admin.laporan');
});

// ================= USER ROUTES =================
Route::middleware(['login.session'])->prefix('user')->controller(UserController::class)->group(function () {
    Route::get('/dashboard', 'dashboard')->name('user.dashboard');
    Route::get('/artikel', 'artikel')->name('user.artikel');
    Route::get('/riwayat-prediksi', 'riwayatPrediksi')->name('user.riwayat-prediksi');
    Route::get('/laporan-visualisasi', 'laporan')->name('user.laporan-visualisasi');
});

// ================= DASHBOARD FORM (OPSIONAL) =================
Route::get('/dashboard/charts', function () {
    return view('dashboard-form.chart');
})->name('dashboard.charts');

Route::get('/dashboard/tables', function () {
    return view('dashboard-form.tables');
})->name('dashboard.tables');

Route::get('/dashboard/riwayat', function () {
    return view('dashboard-form.riwayat');
})->name('dashboard.riwayat');