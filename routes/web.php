<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HargaPasarController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\KalenderTanamController;
use App\Http\Controllers\StatistikController;

// ==================== PUBLIC ROUTES ====================
Route::get('/', function () {
    $statistikService = app(\App\Services\StatistikService::class);
    $hargaRepo        = app(\App\Repositories\Interfaces\HargaPasarRepositoryInterface::class);
    $artikelRepo      = app(\App\Repositories\Interfaces\ArtikelRepositoryInterface::class);
    $dampak   = $statistikService->getDampak();
    $harga    = $hargaRepo->terkini()->take(6);
    $artikel  = $artikelRepo->published()->getCollection()->take(3);
    return view('welcome', compact('dampak', 'harga', 'artikel'));
})->name('home');

Route::get('/harga-pasar',           [HargaPasarController::class, 'index'])->name('harga-pasar.index');
Route::get('/artikel',               [ArtikelController::class, 'index'])->name('artikel.index');
Route::get('/artikel/{slug}',        [ArtikelController::class, 'show'])->name('artikel.show');
Route::get('/kalender-tanam',        [KalenderTanamController::class, 'index'])->name('kalender-tanam.index');

// ==================== AUTH ROUTES ====================
Route::get('/login',  [LoginController::class, 'showForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout',[LoginController::class, 'logout'])->name('logout');
Route::get('/register',  [RegisterController::class, 'showForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// ==================== AUTHENTICATED ROUTES ====================
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Statistik
    Route::get('/statistik', [StatistikController::class, 'index'])->name('statistik.index');

    // Konsultasi — create/store MUST come before {id} to avoid route conflict
    Route::get('/konsultasi',              [KonsultasiController::class, 'index'])->name('konsultasi.index');
    Route::get('/konsultasi/create',       [KonsultasiController::class, 'create'])->middleware('role:petani')->name('konsultasi.create');
    Route::post('/konsultasi',             [KonsultasiController::class, 'store'])->middleware('role:petani')->name('konsultasi.store');
    Route::get('/konsultasi/{id}',         [KonsultasiController::class, 'show'])->name('konsultasi.show');
    Route::post('/konsultasi/{id}/jawab',  [KonsultasiController::class, 'jawab'])->middleware('role:penyuluh,dinas')->name('konsultasi.jawab');
    Route::post('/konsultasi/{id}/tutup',  [KonsultasiController::class, 'tutup'])->name('konsultasi.tutup');

    // Artikel - write access (create BEFORE {slug})
    Route::get('/artikel/create',          [ArtikelController::class, 'create'])->middleware('role:penyuluh,dinas')->name('artikel.create');
    Route::post('/artikel',                [ArtikelController::class, 'store'])->middleware('role:penyuluh,dinas')->name('artikel.store');
    Route::get('/artikel/{id}/edit',       [ArtikelController::class, 'edit'])->middleware('role:penyuluh,dinas')->name('artikel.edit');
    Route::put('/artikel/{id}',            [ArtikelController::class, 'update'])->middleware('role:penyuluh,dinas')->name('artikel.update');
    Route::delete('/artikel/{id}',         [ArtikelController::class, 'destroy'])->middleware('role:penyuluh,dinas')->name('artikel.destroy');

    // Harga - input by dinas
    Route::post('/harga-pasar',            [HargaPasarController::class, 'store'])->middleware('role:dinas')->name('harga-pasar.store');
});
