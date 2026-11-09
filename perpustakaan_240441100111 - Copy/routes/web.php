<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SiswaDashboardController;
use App\Http\Controllers\SiswaBukuController;
use App\Http\Controllers\Api\BukuController as ApiBukuController;
use App\Http\Controllers\Api\PeminjamanController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // A2 SQL Injection 
    Route::get('/buku-cari', [ApiBukuController::class, 'cariRentan'])
    ->name('buku.cari.rentan');
    // A3 CSRF
    Route::get('/buku/{buku}/hapus', [ApiBukuController::class, 'destroy'])
    ->name('buku.hapus.rentan');
    // A4 IDOR
    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'showRentan'])
    ->middleware('auth')
    ->name('peminjaman.show.rentan');
});

require __DIR__.'/auth.php';

Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
    ->middleware('permission:lihat dashboard admin')
    ->name('dashboard');
    Route::get('/dashboard/data-peminjaman', [AdminDashboardController::class, 'peminjaman'])
    ->middleware('permission:lihat dashboard admin')
    ->name('dashboard.data-peminjaman');
    Route::get('/buku', function () {
        return view('admin.buku');
    })->middleware('permission:kelola buku')
    ->name('buku');
    Route::get('/pengguna', [UserController::class, 'index'])
    ->middleware('permission:kelola user')
    ->name('pengguna');
    Route::get('/peminjaman', function () {
        return view('admin.peminjaman');
    })->middleware('permission:kelola peminjaman')
    ->name('peminjaman');
    Route::get('/pengembalian', function () {
        return view('admin.pengembalian');
    })->middleware('permission:kelola pengembalian')
    ->name('pengembalian');
    Route::get('/laporan', function () {
        return view('admin.laporan');
    })->middleware('permission:lihat laporan perpustakaan')
    ->name('laporan');
    Route::get('/profil', [ProfileController::class, 'editAdmin'])
    ->middleware('permission:lihat profil sendiri')
    ->name('profil');
    Route::patch('/profil', [ProfileController::class, 'updateAdmin'])
    ->middleware('permission:ubah profil sendiri')
    ->name('profil.update');
    Route::put('/profil/password', [ProfileController::class, 'updatePasswordAdmin'])
    ->middleware('permission:ubah profil sendiri')
    ->name('profil.password');
});

Route::prefix('petugas')->middleware(['auth', 'role:petugas'])->name('petugas.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'petugas'])
    ->middleware('permission:lihat dashboard petugas')
    ->name('dashboard');    
    Route::get('/buku', function () {
        return view('petugas.buku');
    })->middleware('permission:kelola buku')
    ->name('buku'); // Bisa memakai view buku yang sama
    Route::get('/peminjaman', function () {
        return view('petugas.peminjaman');
    })->middleware('permission:kelola peminjaman')
    ->name('peminjaman');
    Route::get('/pengembalian', function () {
        return view('petugas.pengembalian');
    })->middleware('permission:kelola pengembalian')
    ->name('pengembalian');
    Route::get('/laporan', function () {
        return view('petugas.laporan');
    })->middleware('permission:lihat laporan perpustakaan')
    ->name('laporan');
    Route::get('/profil', [ProfileController::class, 'editPetugas'])
    ->middleware('permission:lihat profil sendiri')
    ->name('profil');
    Route::patch('/profil', [ProfileController::class, 'updatePetugas'])
    ->middleware('permission:ubah profil sendiri')
    ->name('profil.update');
    Route::put('/profil/password', [ProfileController::class, 'updatePasswordPetugas'])
    ->middleware('permission:ubah profil sendiri')
    ->name('profil.password');
});


Route::prefix('siswa')->middleware(['auth', 'role:siswa'])->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])
    ->middleware('permission:lihat dashboard siswa')
    ->name('dashboard');
    Route::get('/buku', [SiswaBukuController::class, 'index'])
    ->middleware('permission:lihat buku')
    ->name('buku');
    Route::get('/peminjaman', function () {
        return view('siswa.peminjaman');
    })->middleware('permission:ajukan peminjaman')
    ->name('peminjaman');
    Route::get('/status-peminjaman', function () {
        return view('siswa.status-peminjaman');
    })->middleware('permission:lihat status peminjaman sendiri')
    ->name('status-peminjaman');
    Route::get('/riwayat', function () {
        return view('siswa.riwayat');
    })->middleware('permission:lihat riwayat peminjaman sendiri')
    ->name('riwayat');
    Route::get('/profil', [ProfileController::class, 'editSiswa'])
        ->middleware('permission:lihat profil sendiri')
        ->name('profil');
    Route::patch('/profil', [ProfileController::class, 'updateSiswa'])
        ->middleware('permission:ubah profil sendiri')
        ->name('profil.update');
    Route::put('/profil/password', [ProfileController::class, 'updatePasswordSiswa'])
        ->middleware('permission:ubah profil sendiri')
        ->name('profil.password');
});