<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\DatauserController;
use App\Http\Controllers\DashboardadminController;
use App\Http\Controllers\PrediksiController;
use App\Http\Controllers\AdminDataPrediksi;
use App\Http\Controllers\AdminVisualisasi;
use App\Http\Controllers\AdminLaporan;
use App\Http\Controllers\AdminKonsultasi;
use App\Http\Controllers\UserKonsultasi;
use App\Http\Controllers\UserRiwayatPrediksiController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ProfileController;


// ==============================
// Public Routes
// ==============================

Route::get('/', [ArtikelController::class, 'landing']);

// Login & Register
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterUserController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [RegisterUserController::class, 'register'])->name('register');

// Optional UI Components (Dashboard Templates)
Route::get('/dashboard/charts', fn() => view('dashboard-form.chart'))->name('dashboard.charts');
Route::get('/dashboard/tables', fn() => view('dashboard-form.tables'))->name('dashboard.tables');
Route::get('/dashboard/riwayat', fn() => view('dashboard-form.riwayat'))->name('dashboard.riwayat');

// Route Dashboard User (Backup / Fallback)
Route::get('/dashboard', function () {
    if (session('user')) {
        return view('dashboard-form.dashboard');
    }
    return redirect('/login');
})->name('user.dashboard');

// ==============================
// Admin Routes
// ==============================

Route::middleware(['login.session', 'admin'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardadminController::class, 'index'])->name('admin.dashboard');

    // Data User
    Route::get('/user', [DatauserController::class, 'index'])->name('admin.user.index');
    Route::post('/user', [DatauserController::class, 'store'])->name('admin.user.store');
    Route::get('/user/edit/{id}', [DatauserController::class, 'edit'])->name('admin.user.edit');
    Route::put('/user/update/{id}', [DatauserController::class, 'update'])->name('admin.user.update');
    Route::delete('/user/{id}', [DatauserController::class, 'destroy'])->name('admin.user.destroy');

    // Artikel
    Route::get('/artikel', [ArtikelController::class, 'index'])->name('admin.artikel.index');
    Route::post('/artikel', [ArtikelController::class, 'store'])->name('admin.artikel.store');
    Route::get('/data-artikel/edit/{id}', [ArtikelController::class, 'edit'])->name('admin.artikel.edit');
    Route::put('/data-artikel/update/{id}', [ArtikelController::class, 'update'])->name('admin.artikel.update');
    Route::delete('/data-artikel/{id}', [ArtikelController::class, 'destroy'])->name('admin.artikel.destroy');

    // Data Prediksi
    Route::get('/hasil-prediksi', [AdminDataPrediksi::class, 'dataPrediksi'])->name('admin.hasil-prediksi');
    Route::get('/hasil-prediksi/{id}', [AdminDataPrediksi::class, 'showDetail'])->name('admin.hasil-prediksi.show');

    // Data Visualisasi
    Route::get('/visualisasi', [AdminVisualisasi::class, 'visualisasi'])->name('admin.visualisasi');

    // Konsultasi
    Route::get('/konsultasi', [AdminKonsultasi::class, 'index'])->name('admin.konsultasi.index');
    Route::get('/konsultasi/{id}', [AdminKonsultasi::class, 'show'])->name('admin.konsultasi.show');
    Route::post('/konsultasi/reply', [AdminKonsultasi::class, 'reply'])->name('admin.konsultasi.reply');
});

// ==============================
// User Routes
// ==============================

Route::middleware(['login.session'])->prefix('user')->group(function () {
    Route::get('/dashboard', [UserDashboard::class, 'dashboard'])->name('user.dashboard');

    // Konsultasi
    Route::get('/konsultasi', [UserKonsultasi::class, 'index'])->name('konsultasi.index');
    Route::post('/konsultasi', [UserKonsultasi::class, 'store'])->name('konsultasi.store');
    Route::get('/konsultasi/create', [UserKonsultasi::class, 'create'])->name('konsultasi.create');
    Route::get('/konsultasi/{id}', [UserKonsultasi::class, 'show'])->name('konsultasi.show');
    Route::delete('/konsultasi/{id}', [UserKonsultasi::class, 'destroy'])->name('konsultasi.destroy');

    // Route UserRiwayatPrediksiController
    Route::get('/riwayat-deteksi', [UserRiwayatPrediksiController::class, 'dataPrediksi'])->name('user.riwayat-deteksi');
    Route::get('/riwayat-deteksi/{id}', [UserRiwayatPrediksiController::class, 'showDetail'])->name('user.riwayat-deteksi.show');
    Route::delete('/riwayat-deteksi/{id}', [UserRiwayatPrediksiController::class, 'delete'])->name('user.riwayat-deteksi.delete');
});

// Route publik / umum
//Route::get('/laporan', [UserController::class, 'laporan']);
//Route::get('/riwayat-prediksi', [UserRiwayatPrediksiController::class, 'index'])->name('riwayat.prediksi');


// Tampilan input nama (Forgot)
// Tampilkan form input nama (forgot password step 1)

// Route untuk password reset

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

// Proses input nama dan tampilkan form reset password
Route::get('password/reset-form', [ResetPasswordController::class, 'showResetForm'])->name('password.reset.form');

// Simpan password baru
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// pengaturan profile   
Route::middleware('login.session')->group(function () {
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
});
