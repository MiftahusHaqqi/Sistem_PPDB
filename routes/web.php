<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| ROUTE PUBLIK
|--------------------------------------------------------------------------
*/

// Beranda / Welcome
Route::get('/', [HomeController::class, 'index'])->name('home');

// Cek Status dari Welcome
Route::post('/cek-status', [HomeController::class, 'cekStatus'])->name('cek.status');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

/*
|--------------------------------------------------------------------------
| ROUTE TERPROTEKSI
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | SISWA
    |--------------------------------------------------------------------------
    */
    Route::prefix('siswa')->middleware('role:siswa')->group(function () {

        Route::get('/dashboard', [SiswaController::class, 'index'])
            ->name('siswa.dashboard');

        Route::get('/pendaftaran', [SiswaController::class, 'pendaftaran'])
            ->name('siswa.pendaftaran');

        Route::post('/pendaftaran', [SiswaController::class, 'store'])
            ->name('siswa.pendaftaran.store');

        Route::get('/status', [SiswaController::class, 'status'])
            ->name('siswa.status');

        Route::get('/cetak-bukti', [SiswaController::class, 'cetakBukti'])
            ->name('siswa.cetak');
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->middleware('role:admin')->group(function () {

        Route::get('/dashboard', [AdminController::class, 'index'])
            ->name('admin.dashboard');

        // Verifikasi
        Route::get('/verifikasi', [AdminController::class, 'verifikasi'])
            ->name('admin.verifikasi');

        Route::patch('/verifikasi/{id}', [AdminController::class, 'verifikasiPendaftar'])
            ->name('admin.verifikasi.update');

        Route::patch('/verifikasi/{id}/batal', [AdminController::class, 'batalVerifikasiPendaftar'])
            ->name('admin.verifikasi.batal');

        Route::patch('/verifikasi/{id}/tolak', [AdminController::class, 'tolakPendaftar'])
            ->name('admin.verifikasi.tolak');

        // Detail pendaftar
        Route::get('/pendaftar/{id}', [AdminController::class, 'show'])
            ->name('admin.pendaftar.show');

        // =====================
        // DATA JURUSAN (CRUD)
        // =====================
        Route::get('/jurusan', [AdminController::class, 'jurusan'])
            ->name('admin.jurusan');

        Route::post('/jurusan', [AdminController::class, 'jurusanStore'])
            ->name('admin.jurusan.store');

        Route::put('/jurusan/{id}', [AdminController::class, 'jurusanUpdate'])
            ->name('admin.jurusan.update');

        Route::delete('/jurusan/{id}', [AdminController::class, 'jurusanDelete'])
            ->name('admin.jurusan.delete');

        // Umumkan hasil akhir
        Route::post('/umumkan-final', [AdminController::class, 'umumkanFinal'])
            ->name('admin.umumkan.final');
    });
});
