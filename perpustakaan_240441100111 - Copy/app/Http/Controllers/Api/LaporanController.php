<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Validasi filter tanggal
        $validated = $request->validate([
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);

        // Default periode: awal bulan sampai hari ini
        $tanggalMulai = $validated['tanggal_mulai']
            ?? now()->startOfMonth()->toDateString();

        $tanggalSelesai = $validated['tanggal_selesai']
            ?? now()->toDateString();

        // Query dasar berdasarkan tanggal peminjaman
        $query = Peminjaman::whereBetween('tanggal_pinjam', [
            $tanggalMulai,
            $tanggalSelesai,
        ]);

        // Ringkasan laporan
        $statistik = [
            'total_peminjaman' => (clone $query)->count(),

            'total_pengembalian' => (clone $query)
                ->whereNotNull('tanggal_dikembalikan')
                ->count(),

            'peminjaman_aktif' => (clone $query)
                ->whereNull('tanggal_dikembalikan')
                ->count(),

            'peminjaman_terlambat' => (clone $query)
                ->whereNull('tanggal_dikembalikan')
                ->whereNotNull('tanggal_kembali')
                ->whereDate('tanggal_kembali', '<', today())
                ->count(),

            'total_denda_keterlambatan' => (clone $query)
                ->sum('denda_keterlambatan'),

            'total_denda_kondisi' => (clone $query)
                ->sum('denda_kondisi'),
        ];

        $statistik['total_denda'] =
            $statistik['total_denda_keterlambatan']
            + $statistik['total_denda_kondisi'];

        // Rekapitulasi peminjaman setiap buku
        $rekapBuku = Buku::with('kategori')
            ->withCount([
                'peminjaman as total_dipinjam' => function ($q) use ($tanggalMulai, $tanggalSelesai) {
                    $q->whereBetween('tanggal_pinjam', [
                        $tanggalMulai,
                        $tanggalSelesai,
                    ]);
                },

                'peminjaman as total_dikembalikan' => function ($q) use ($tanggalMulai, $tanggalSelesai) {
                    $q->whereBetween('tanggal_pinjam', [
                        $tanggalMulai,
                        $tanggalSelesai,
                    ])->whereNotNull('tanggal_dikembalikan');
                },

                'peminjaman as total_terlambat' => function ($q) use ($tanggalMulai, $tanggalSelesai) {
                    $q->whereBetween('tanggal_pinjam', [
                        $tanggalMulai,
                        $tanggalSelesai,
                    ])
                    ->whereNotNull('tanggal_dikembalikan')
                    ->whereColumn('tanggal_dikembalikan', '>', 'tanggal_kembali');
                },
            ])
            ->orderByDesc('total_dipinjam')
            ->get();

        // Detail transaksi peminjaman
        $transaksi = Peminjaman::with(['anggota', 'buku.kategori'])
            ->whereBetween('tanggal_pinjam', [
                $tanggalMulai,
                $tanggalSelesai,
            ])
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Laporan berhasil diambil.',
            'periode' => [
                'tanggal_mulai' => $tanggalMulai,
                'tanggal_selesai' => $tanggalSelesai,
            ],
            'statistik' => $statistik,
            'rekap_buku' => $rekapBuku,
            'transaksi' => $transaksi,
        ]);
    }
}