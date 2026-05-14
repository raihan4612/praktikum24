<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\HakAksesController;
use App\Http\Controllers\AuthController;

// ─── Auth Routes (tanpa login) ───────────────────────────────────────────────
Route::get('/',       [AuthController::class, 'showLogin'])->name('login');
Route::get('login',   [AuthController::class, 'showLogin'])->name('login');
Route::post('login',  [AuthController::class, 'login'])->name('do-login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// ─── Routes yang butuh LOGIN (admin & user bisa akses) ───────────────────────
Route::middleware('auth')->group(function () {

    // Mahasiswa - Read (semua role boleh lihat)
    Route::get('data-mahasiswa',        [MahasiswaController::class, 'index']) ->name('data-mahasiswa');
    Route::get('show-mahasiswa/{id}',   [MahasiswaController::class, 'show'])  ->name('show-mahasiswa');

    // ─── Routes khusus ADMIN ─────────────────────────────────────────────────
    Route::middleware('admin')->group(function () {

        // Mahasiswa - Create, Update, Delete
        Route::get('create-mahasiswa',          [MahasiswaController::class, 'create']) ->name('create-mahasiswa');
        Route::post('simpan-mahasiswa',         [MahasiswaController::class, 'store'])  ->name('simpan-mahasiswa');
        Route::get('edit-mahasiswa/{id}',       [MahasiswaController::class, 'edit'])   ->name('edit-mahasiswa');
        Route::put('update-mahasiswa/{id}',     [MahasiswaController::class, 'update']) ->name('update-mahasiswa');
        Route::delete('hapus-mahasiswa/{id}',   [MahasiswaController::class, 'destroy'])->name('hapus-mahasiswa');

        // Hak Akses - full CRUD
        Route::get('hak-akses',                 [HakAksesController::class, 'index'])  ->name('hak-akses');
        Route::get('create-hak-akses',          [HakAksesController::class, 'create']) ->name('create-hak-akses');
        Route::post('simpan-hak-akses',         [HakAksesController::class, 'store'])  ->name('simpan-hak-akses');
        Route::get('edit-hak-akses/{id}',       [HakAksesController::class, 'edit'])   ->name('edit-hak-akses');
        Route::put('update-hak-akses/{id}',     [HakAksesController::class, 'update']) ->name('update-hak-akses');
        Route::delete('hapus-hak-akses/{id}',   [HakAksesController::class, 'destroy'])->name('hapus-hak-akses');
    });
});