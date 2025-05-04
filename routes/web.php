<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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