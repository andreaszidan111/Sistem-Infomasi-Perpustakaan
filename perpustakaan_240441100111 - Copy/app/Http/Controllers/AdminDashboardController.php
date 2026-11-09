<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\peminjaman;
use App\Models\buku;
use App\Models\anggota;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $jumlahBuku = buku::count();
        $jumlahAnggota = anggota::count();
        $jumlahPeminjaman = peminjaman::whereNull('tanggal_kembali')->count();
        $jumlahPengembalian = peminjaman::whereNotNull('tanggal_kembali')->count();
        $totalTransaksi = peminjaman::count();
        $peminjamanTerbaru = peminjaman::with(['anggota', 'buku'])
        ->latest()
        ->paginate(5);

        return view('admin.dashboard', [
            'jumlahBuku' => $jumlahBuku,
            'jumlahAnggota' => $jumlahAnggota,
            'jumlahPeminjaman' => $jumlahPeminjaman,
            'jumlahPengembalian' => $jumlahPengembalian,
            'totalTransaksi' => $totalTransaksi,
            'peminjamanTerbaru' => $peminjamanTerbaru,
        ]);
    }
    
    // Dashboard Petugas
    public function petugas()
    {
        $jumlahBuku = buku::count();

        $peminjamanAktif = peminjaman::where(
            'status',
            peminjaman::STATUS_DISETUJUI
        )->whereNull('tanggal_dikembalikan')->count();

        $antreanMenunggu = peminjaman::where(
            'status',
            peminjaman::STATUS_MENUNGGU
        )->count();

        $bukuTerlambat = peminjaman::where(
            'status',
            peminjaman::STATUS_DISETUJUI
        )
            ->whereNull('tanggal_dikembalikan')
            ->whereDate('tanggal_kembali', '<', now()->toDateString())
            ->count();

        $peminjamanTerbaru = peminjaman::with(['anggota', 'buku'])
            ->latest()
            ->take(5)
            ->get();

        return view('petugas.dashboard', compact(
            'jumlahBuku',
            'peminjamanAktif',
            'antreanMenunggu',
            'bukuTerlambat',
            'peminjamanTerbaru'
        ));
    }

    public function peminjaman(Request $request)
    {
        $peminjaman = peminjaman::with(['anggota', 'buku'])
            ->latest()
            ->paginate(5);

        return response()->json([
            'data' => $peminjaman->items(),
            'meta' => [
                'current_page' => $peminjaman->currentPage(),
                'last_page' => $peminjaman->lastPage(),
                'total' => $peminjaman->total(),
            ],
        ]);
    }
}
