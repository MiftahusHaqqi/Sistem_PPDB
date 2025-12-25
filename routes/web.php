<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController; // Pastikan nanti buat controller ini

// --- 1. Rute Publik (Sebelum Login) ---
Route::get('/', function () {
    return view('welcome');
});

// Rute Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute Register (Taruh di dekat Rute Login)
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');


// --- 2. Rute Terproteksi (Harus Login) ---
Route::middleware(['auth'])->group(function () {

    // --- GRUP ROUTE SISWA ---
    Route::prefix('siswa')->middleware(['role:siswa'])->group(function () {
        Route::get('/dashboard', [SiswaController::class, 'index'])->name('siswa.dashboard');
        Route::get('/pendaftaran', [SiswaController::class, 'pendaftaran'])->name('siswa.pendaftaran');
        Route::post('/pendaftaran', [SiswaController::class, 'store'])->name('siswa.pendaftaran.store');
        Route::get('/status', [SiswaController::class, 'status'])->name('siswa.status');
    });

    // --- GRUP ROUTE ADMIN ---
    Route::prefix('admin')->middleware(['role:admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/verifikasi', [AdminController::class, 'verifikasi'])->name('admin.verifikasi');
        Route::get('/jurusan', [AdminController::class, 'jurusan'])->name('admin.jurusan');
        // Tambahkan route cetak laporan atau seleksi di sini nanti

        Route::post('/umumkan-final', [AdminController::class, 'umumkanFinal'])->name('admin.umumkan.final');
        
        Route::get('/jurusan', [AdminController::class, 'jurusan'])->name('admin.jurusan');
        // TAMBAHKAN BARIS DI BAWAH INI:
        Route::post('/jurusan', [AdminController::class, 'jurusanStore'])->name('admin.jurusan.store');
        });
        // Rute untuk Update Jurusan
        Route::put('/jurusan/{id}', [AdminController::class, 'jurusanUpdate'])->name('admin.jurusan.update');

        // Rute untuk Hapus Jurusan
        Route::delete('/jurusan/{id}', [AdminController::class, 'jurusanDelete'])->name('admin.jurusan.delete');

Route::post('/admin/verifikasi/{id}', [AdminController::class, 'updateStatus'])->name('admin.verifikasi.update');

Route::get('/cetak-bukti', [SiswaController::class, 'cetakBukti'])->name('siswa.cetak');

});