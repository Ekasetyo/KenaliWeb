<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DatauserController;

Route::get('/', function () {
    return view('landing-page.landing-page');
});

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
    Route::get('/dashboard', 'dashboard')->name('admin.dashboard');
    //Route::get('/data-user', 'dataUser')->name('admin.data-user');
    Route::get('/data-artikel', 'dataArtikel')->name('admin.data-artikel');
    Route::get('/data-saran', 'dataSaran')->name('admin.data-saran');
    Route::get('/hasil-prediksi', 'dataPrediksi')->name('admin.hasil-prediksi');
    Route::get('/visualisasi', 'visualisasi')->name('admin.visualisasi');
    Route::get('/laporan', 'laporan')->name('admin.laporan');
});


//Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/admin/dashboard', function () {
    if (session('user') && session('user')['status'] === 'admin') {
        return view('admin.dashboard-admin');
    }
    return redirect('/login');
})->name('admin.dashboard');


// Route Dashboard User
Route::get('/dashboard', function () {
    if (session('user')) {
        return view('dashboard-form.dashboard');
    }
    return redirect('/login');
})->name('user.dashboard');


//untuk data-user
Route::get('/admin/data-user', [DatauserController::class, 'index'])->name('admin.data-user');
Route::post('/admin/user', [DatauserController::class, 'store'])->name('admin.user.store');
Route::delete('/admin/user/{id}', [DatauserController::class, 'destroy'])->name('admin.user.destroy');
