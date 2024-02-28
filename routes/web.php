<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PerhitunganController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\TribeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::resource('kriteria', KriteriaController::class);
Route::resource('penilaian', PenilaianController::class);
Route::resource('perhitungan', PerhitunganController::class);
Route::resource('riwayat', RiwayatController::class);
Route::resource('tribe', TribeController::class);


Auth::routes();
Route::post('/perhitungan/simpan', [PerhitunganController::class, 'simpan'])->name('perhitungan.simpan');
Route::get('/riwayat-perhitungan', [PerhitunganController::class, 'riwayat'])->name('perhitungan.riwayat');
Route::get('/perangkingan', [PerhitunganController::class, 'rangking'])->name('perhitungan.rangking');
Route::get('/perhitungan/perangkingan/detail', [PerhitunganController::class, 'detailPerangkingan'])->name('perhitungan.perangkingan.detail');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
