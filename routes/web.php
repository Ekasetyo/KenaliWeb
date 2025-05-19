<?php

use App\Http\Controllers\DashboardadminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DatauserController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\PrediksiController;

Route::get('/', [ArtikelController::class, 'landing']);


Route::get('/login', function () {
    return view('login-register.login');
});

Route::get('/register', function () {
    return view('login-register.register');
});

Route::get('/dashboard', function () {
    return view('dashboard-form.dashboard');
});

// Dashboard routes
Route::get('/dashboard/charts', function () {
    return view('dashboard-form.chart');
})->name('dashboard.charts');

Route::get('/dashboard/tables', function () {
    return view('dashboard-form.tables');
})->name('dashboard.tables');

Route::get('/dashboard/riwayat', function () {
    return view('dashboard-form.riwayat');
})->name('dashboard.riwayat');


//Admin

// routes/web.php
Route::prefix('admin')->controller(AdminController::class)->group(function () {
    // Route::get('/dashboard', 'dashboard')->name('admin.dashboard');
    //Route::get('/layouts', 'layouts')->name('admin.layouts');
    // Route::get('/data-artikel', 'dataArtikel')->name('admin.data-artikel');
    Route::get('/hasil-prediksi', 'dataPrediksi')->name('admin.hasil-prediksi');
    Route::get('/visualisasi', 'visualisasi')->name('admin.visualisasi');
    Route::get('/laporan', 'laporan')->name('admin.laporan');
});



//Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/admin/dashboard', [DashboardadminController::class, 'index'])->name('admin.dashboard');


// Route Dashboard User
Route::get('/dashboard', function () {
    if (session('user')) {
        return view('dashboard-form.dashboard');
    }
    return redirect('/login');
})->name('user.dashboard');


//untuk data-user
Route::get('/admin/user', [DatauserController::class, 'index'])->name('admin.user.index');
Route::post('/admin/user', [DatauserController::class, 'store'])->name('admin.user.store');
Route::delete('/admin/user/{id}', [DatauserController::class, 'destroy'])->name('admin.user.destroy');
Route::get('/admin/user/edit/{id}', [DatauserController::class, 'edit'])->name('admin.user.edit');
Route::put('/admin/user/update/{id}', [DatauserController::class, 'update'])->name('admin.user.update');


//data artikel
Route::get('/admin/artikel', [ArtikelController::class, 'index'])->name('admin.artikel.index');
Route::post('/admin/artikel', [ArtikelController::class, 'store'])->name('admin.artikel.store');
Route::get('/admin/data-artikel/edit/{id}', [ArtikelController::class, 'edit'])->name('admin.artikel.edit');
Route::put('/admin/data-artikel/update/{id}', [ArtikelController::class, 'update'])->name('admin.artikel.update');
Route::delete('/admin/data-artikel/{id}', [ArtikelController::class, 'destroy'])->name('admin.artikel.destroy');
Route::get('/', [ArtikelController::class, 'landing']);




//User

// routes/web.php
Route::prefix('user')->controller(UserController::class)->group(function () {
    Route::get('/dashboard', 'dashboard')->name('user.dashboard');
    Route::get('/riwayat-prediksi', 'riwayatPrediksi')->name('user.riwayat-prediksi');
    Route::get('/laporan-visualisasi', 'laporan')->name('user.laporan-visualisasi');
    Route::middleware(['auth'])->post('/user/ubah-password', [UserController::class, 'ubahPassword'])->name('user.ubah-password');


});
