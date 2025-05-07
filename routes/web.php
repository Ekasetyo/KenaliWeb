<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; // Pastikan ini diimpor

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


Route::get('/dashboard/data-user', [UserController::class, 'index'])->name('data-user');