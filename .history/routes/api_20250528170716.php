<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RiwayatDeteksiController;
use App\Http\Controllers\Api\ArtikelMobileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/deteksi', [DeteksiController::class, 'deteksi'])->name('deteksi');
Route::post('riwayat', [RiwayatDeteksiController::class, 'getRiwayat'])->name('riwayat');
Route::post('/artikel', [ArtikelMobileController::class, 'getartikel'])->name('artikel');



Route::delete('/riwayat/{id}', [RiwayatDeteksiController::class, 'destroy'])->name('hapus.riwayat');
Route::post('/update-profile', [UserMobileController::class, 'updateProfile'])->name('update.profile');
