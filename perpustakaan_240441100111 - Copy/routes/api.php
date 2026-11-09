<?php

use App\Http\Controllers\Api\BukuController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PeminjamanController;
use App\Http\Controllers\Api\LaporanController;
use App\Models\anggota;
use Illuminate\Support\Facades\Route;

Route::get('/buku', [BukuController::class, 'index'])
    ->middleware(['auth:sanctum', 'permission:lihat buku|lihat daftar buku|kelola buku'])
    ->name('api.buku.index');
Route::get('/buku/{id}', [BukuController::class, 'show'])
    ->middleware(['auth:sanctum', 'permission:lihat buku|lihat daftar buku|kelola buku'])
    ->name('api.buku.show');

Route::post('/buku', [BukuController::class, 'store'])
    ->middleware(['auth:sanctum', 'can:kelola-buku'])
    ->name('api.buku.store');
Route::put('/buku/{buku}', [BukuController::class, 'update'])
    ->middleware(['auth:sanctum', 'can:kelola-buku'])
    ->name('api.buku.update');
Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])
    ->middleware(['auth:sanctum', 'can:kelola-buku'])
    ->name('api.buku.destroy');
Route::get('/rekap/buku-per-kategori', [BukuController::class, 'bukuPerKategori'])
    ->middleware(['auth:sanctum', 'permission:lihat laporan perpustakaan'])
    ->name('api.rekap.buku-per-kategori');
Route::get('/rekap/peminjaman-per-buku', [BukuController::class, 'peminjamanPerBuku'])
    ->middleware(['auth:sanctum', 'permission:lihat laporan perpustakaan'])
    ->name('api.rekap.peminjaman-per-buku');

Route::post('/pengguna', [UserController::class, 'store'])
    ->middleware(['auth:sanctum', 'role:admin', 'permission:kelola user'])
    ->name('api.pengguna.store');
Route::get('/pengguna/{id}', [UserController::class, 'show'])
    ->middleware(['auth:sanctum', 'role:admin', 'permission:kelola user'])
    ->name('api.pengguna.show');
Route::put('/pengguna/{id}', [UserController::class, 'update'])
    ->middleware(['auth:sanctum', 'role:admin', 'permission:kelola user'])
    ->name('api.pengguna.update');
Route::delete('/pengguna/{id}', [UserController::class, 'destroy'])
    ->middleware(['auth:sanctum', 'role:admin', 'permission:kelola user'])
    ->name('api.pengguna.destroy');

Route::apiResource('peminjaman', PeminjamanController::class)
    ->middleware(['auth:sanctum', 'permission:kelola peminjaman'])
    ->except(['show'])
    ->names([
        'index' => 'api.peminjaman.index',
        'store' => 'api.peminjaman.store',
        'show' => 'api.peminjaman.show',
        'update' => 'api.peminjaman.update',
        'destroy' => 'api.peminjaman.destroy',
    ]);

Route::post('/siswa/peminjaman', [PeminjamanController::class, 'storeSiswa'])
    ->middleware(['auth:sanctum', 'permission:ajukan peminjaman'])
    ->name('api.siswa.peminjaman.store');

Route::get('/anggota', function () {
    return response()->json([
        'data' => Anggota::select('id', 'nama', 'email')->orderBy('nama')->get(),
    ]);
})->middleware(['auth:sanctum', 'permission:kelola peminjaman']);

Route::post('/peminjaman/{id}/pengembalian', [PeminjamanController::class, 'pengembalian'])
    ->middleware(['auth:sanctum', 'permission:catat pengembalian'])
    ->name('api.peminjaman.pengembalian');
Route::get('/pengembalian', [PeminjamanController::class, 'daftarPengembalian'])
    ->middleware(['auth:sanctum', 'permission:kelola pengembalian'])
    ->name('api.pengembalian.index');

Route::get('/laporan', [LaporanController::class, 'index'])
    ->middleware([
        'auth:sanctum',
        'permission:lihat laporan perpustakaan|lihat laporan'
    ])
    ->name('api.laporan.index');

Route::post('/peminjaman/{id}/setujui', [PeminjamanController::class, 'setujui'])
    ->middleware(['auth:sanctum', 'permission:proses persetujuan peminjaman'])
    ->name('api.peminjaman.setujui');

Route::post('/peminjaman/{id}/tolak', [PeminjamanController::class, 'tolak'])
    ->middleware(['auth:sanctum', 'permission:proses persetujuan peminjaman'])
    ->name('api.peminjaman.tolak');

Route::get('/siswa/peminjaman', [PeminjamanController::class, 'indexSiswa'])
    ->middleware([
        'auth:sanctum',
        'role:siswa',
        'permission:lihat status peminjaman sendiri'
    ])
    ->name('api.siswa.peminjaman.index');
Route::get('/siswa/riwayat', [PeminjamanController::class, 'riwayatSiswa'])
    ->middleware([
        'auth:sanctum',
        'role:siswa',
        'permission:lihat riwayat peminjaman sendiri'
    ])
    ->name('api.siswa.riwayat');