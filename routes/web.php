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

// ==============================
// Public Routes
// ==============================

Route::get('/', [ArtikelController::class, 'landing']);

// Login & Register
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', function () {
    return view('login-register.register');
})->name('register');
Route::get('/register', [RegisterUserController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [RegisterUserController::class, 'register'])->name('register');

// Optional UI Components (Dashboard Templates)
Route::get('/dashboard/charts', fn () => view('dashboard-form.chart'))->name('dashboard.charts');
Route::get('/dashboard/tables', fn () => view('dashboard-form.tables'))->name('dashboard.tables');
Route::get('/dashboard/riwayat', fn () => view('dashboard-form.riwayat'))->name('dashboard.riwayat');

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

    // Data Prediksi, Visualisasi, Laporan
    Route::get('/hasil-prediksi', [AdminDataPrediksi::class, 'dataPrediksi'])->name('admin.hasil-prediksi');
    Route::get('/visualisasi', [AdminVisualisasi::class, 'visualisasi'])->name('admin.visualisasi');
    Route::get('/laporan', [AdminLaporan::class, 'laporan'])->name('admin.laporan');

    // Konsultasi (View ada di views/laporan)
    Route::get('/konsultasi', [AdminKonsultasi::class, 'index'])->name('admin.consultations.index');
    Route::get('/konsultasi/{id}', [AdminKonsultasi::class, 'show'])->name('admin.consultations.show');
    Route::post('/konsultasi/reply', [AdminKonsultasi::class, 'reply'])->name('admin.consultations.reply');
    Route::post('/konsultasi/{id}/close', [AdminKonsultasi::class, 'close'])->name('admin.consultations.close');
});

// ==============================
// User Routes
// ==============================

Route::middleware(['login.session'])->prefix('user')->group(function () {
    // Route UserController
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/artikel', [UserController::class, 'artikel'])->name('user.artikel');
    Route::get('/konsultasi', [UserController::class, 'konsultasi'])->name('user.konsultasi');
    Route::get('/laporan-visualisasi', [UserController::class, 'laporan'])->name('user.laporan-visualisasi');
    Route::post('/ubah-password', [UserController::class, 'ubahPassword'])->name('user.ubah-password')->middleware('auth');

    Route::get('/konsultasi', [UserController::class, 'konsultasi'])->name('user.konsultasi');
    Route::post('/konsultasi', [UserController::class, 'store'])->name('user.consultations.store');
    Route::post('/konsultasi/reply', [UserController::class, 'reply'])->name('user.consultations.reply');

    // Route UserRiwayatPrediksiController (dipisah)
    Route::get('/riwayat-deteksi', [UserRiwayatPrediksiController::class, 'dataPrediksi'])->name('user.riwayat-deteksi');
});

// Jika kamu masih pakai middleware auth terpisah untuk konsultasi:
// Route::middleware(['auth'])->prefix('user')->group(function () {
//     Route::get('/konsultasi', [UserController::class, 'index'])->name('user.consultations.index');
//     Route::post('/konsultasi', [UserController::class, 'store'])->name('user.consultations.store');
//     Route::post('/konsultasi/reply', [UserController::class, 'reply'])->name('user.consultations.reply');
// });

// Route publik / umum
Route::get('/laporan', [UserController::class, 'laporan']);
Route::get('/riwayat-prediksi', [UserRiwayatPrediksiController::class, 'index'])->name('riwayat.prediksi');

// Route untuk password reset, dll (tidak diubah)
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');