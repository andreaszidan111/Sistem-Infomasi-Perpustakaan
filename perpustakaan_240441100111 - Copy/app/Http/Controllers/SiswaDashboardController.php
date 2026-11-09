<?php

namespace App\Http\Controllers;

use App\Models\peminjaman;
use Illuminate\Http\Request;

class SiswaDashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data anggota berdasarkan akun siswa yang login
        $anggota = $request->user()->anggota;

        // Pastikan akun siswa sudah terhubung dengan data anggota
        abort_unless(
            $anggota,
            403,
            'Akun siswa belum terhubung dengan data anggota.'
        );

        // Ambil seluruh peminjaman milik siswa
        $query = $anggota->peminjaman();

        // Statistik peminjaman
        $totalPeminjaman = (clone $query)->count();

        $peminjamanMenunggu = (clone $query)
            ->where('status', peminjaman::STATUS_MENUNGGU)
            ->count();

        $peminjamanDisetujui = (clone $query)
            ->where('status', peminjaman::STATUS_DISETUJUI)
            ->count();

        $peminjamanDitolak = (clone $query)
            ->where('status', peminjaman::STATUS_DITOLAK)
            ->count();

        // Lima peminjaman terbaru
        $peminjamanTerbaru = (clone $query)
            ->with('buku')
            ->latest()
            ->take(5)
            ->get();

        return view('siswa.dashboard', compact(
            'totalPeminjaman',
            'peminjamanMenunggu',
            'peminjamanDisetujui',
            'peminjamanDitolak',
            'peminjamanTerbaru'
        ));
    }
}
