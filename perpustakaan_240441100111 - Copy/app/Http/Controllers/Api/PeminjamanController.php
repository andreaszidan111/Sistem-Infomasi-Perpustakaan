<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\peminjaman;
use App\Models\buku;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Gate;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $peminjaman = Peminjaman::with(['anggota', 'buku'])
            ->latest()
            ->get();
        $hariIni = Carbon::today();

        $statistik = [
            'total_transaksi' => Peminjaman::count(),

            'peminjaman_hari_ini' => Peminjaman::whereDate(
                'tanggal_pinjam',
                $hariIni
            )->count(),

            'jatuh_tempo_hari_ini' => Peminjaman::whereDate(
                'tanggal_kembali',
                $hariIni
            )->count(),

            'lewat_jatuh_tempo' => Peminjaman::whereDate(
                'tanggal_kembali',
                '<',
                $hariIni
            )->count(),
        ];

        return response()->json([
            'data' => $peminjaman,
            'statistik' => $statistik,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'anggota_id' => 'required|exists:anggotas,id',
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
        ]);

        $validated['status'] = Peminjaman::STATUS_MENUNGGU;
        $peminjaman = Peminjaman::create($validated);

        return response()->json([
            'message' => 'Peminjaman berhasil ditambahkan.',
            'data' => $peminjaman,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $peminjaman = Peminjaman::with(['anggota', 'buku'])
            ->findOrFail($id);
        
            Gate::authorize('view', $peminjaman);

        return response()->json([
            'data' => $peminjaman,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'anggota_id' => 'required|exists:anggotas,id',
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
        ]);

        return DB::transaction(function () use ($id, $validated) {
            $peminjaman = Peminjaman::query()
                ->lockForUpdate()
                ->findOrFail($id);

            if ($peminjaman->status !== Peminjaman::STATUS_MENUNGGU) {
                return response()->json([
                    'message' => 'Hanya peminjaman berstatus menunggu yang dapat diubah.',
                ], 422);
            }

            $peminjaman->update($validated);

            return response()->json([
                'message' => 'Peminjaman berhasil diperbarui.',
            ]);
        });
    }

    /**
     * Update the specified resource in storage.
     */
    public function edit(Request $request, peminjaman $peminjaman)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {
            $peminjaman = Peminjaman::query()
                ->lockForUpdate()
                ->findOrFail($id);

            if (!in_array($peminjaman->status, [
                Peminjaman::STATUS_MENUNGGU,
                Peminjaman::STATUS_DITOLAK,
            ], true) || $peminjaman->tanggal_dikembalikan !== null) {
                return response()->json([
                    'message' => 'Hanya peminjaman yang belum diproses atau ditolak yang dapat dihapus.',
                ], 422);
            }

            $peminjaman->delete();

            return response()->json([
                'message' => 'Peminjaman berhasil dihapus.',
            ]);
        });
    }

    public function pengembalian(Request $request, $id)
    {
        $validated = $request->validate([
            'kondisi_buku' => 'required|in:Baik,Rusak Ringan,Rusak Berat,Hilang',
        ]);

        return DB::transaction(function () use ($id, $validated) {
            $peminjaman = Peminjaman::query()
                ->lockForUpdate()
                ->findOrFail($id);

            if ($peminjaman->status !== Peminjaman::STATUS_DISETUJUI) {
                return response()->json([
                    'message' => 'Hanya peminjaman yang disetujui yang dapat dikembalikan.',
                ], 422);
            }

            if ($peminjaman->tanggal_dikembalikan !== null) {
                return response()->json([
                    'message' => 'Transaksi ini sudah diproses pengembaliannya.',
                ], 422);
            }

            $buku = buku::query()
                ->lockForUpdate()
                ->findOrFail($peminjaman->buku_id);

            $hariIni = now()->toDateString();
            $tanggalKembali = Carbon::parse($peminjaman->tanggal_kembali);
            $tanggalPengembalian = Carbon::parse($hariIni);

            $hariTerlambat = $tanggalPengembalian->greaterThan($tanggalKembali)
                ? $tanggalKembali->diffInDays($tanggalPengembalian)
                : 0;

            $dendaKeterlambatan = $hariTerlambat * 5000;

            $dendaKondisi = match ($validated['kondisi_buku']) {
                'Rusak Ringan' => 5000,
                'Rusak Berat' => 15000,
                'Hilang' => 50000,
                default => 0,
            };

            $peminjaman->update([
                'tanggal_dikembalikan' => $hariIni,
                'kondisi_buku' => $validated['kondisi_buku'],
                'denda_keterlambatan' => $dendaKeterlambatan,
                'denda_kondisi' => $dendaKondisi,
            ]);

            if (in_array($validated['kondisi_buku'], ['Baik', 'Rusak Ringan'], true)) {
                $buku->increment('stok');
            }

            return response()->json([
                'message' => 'Pengembalian berhasil diproses.',
                'data' => [
                    'id' => $peminjaman->id,
                    'tanggal_dikembalikan' => $hariIni,
                    'hari_terlambat' => $hariTerlambat,
                    'kondisi_buku' => $validated['kondisi_buku'],
                    'denda_keterlambatan' => $dendaKeterlambatan,
                    'denda_kondisi' => $dendaKondisi,
                    'total_denda' => $dendaKeterlambatan + $dendaKondisi,
                ],
            ]);
        });
    }

    public function daftarPengembalian()
    {
        $peminjaman = Peminjaman::with(['anggota', 'buku'])
            ->whereNull('tanggal_dikembalikan')
            ->latest()
            ->get();

        return response()->json([
            'data' => $peminjaman,
            'total' => $peminjaman->count(),
        ]);
    }

    public function setujui($id)
    {
        return DB::transaction(function () use ($id) {
            $peminjaman = Peminjaman::query()
                ->lockForUpdate()
                ->findOrFail($id);

            if ($peminjaman->status !== Peminjaman::STATUS_MENUNGGU) {
                return response()->json([
                    'message' => 'Hanya peminjaman berstatus menunggu yang dapat disetujui.',
                ], 422);
            }

            $buku = Buku::query()
                ->lockForUpdate()
                ->findOrFail($peminjaman->buku_id);

            if ($buku->stok < 1) {
                return response()->json([
                    'message' => 'Stok buku tidak tersedia.',
                ], 422);
            }

            $buku->decrement('stok');
            $peminjaman->update([
                'status' => Peminjaman::STATUS_DISETUJUI,
            ]);

            return response()->json([
                'message' => 'Peminjaman berhasil disetujui.',
                'data' => $peminjaman->fresh()->load(['anggota', 'buku']),
            ]);
        });
    }

    public function tolak($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== Peminjaman::STATUS_MENUNGGU) {
            return response()->json([
                'message' => 'Hanya peminjaman berstatus menunggu yang dapat ditolak.',
            ], 422);
        }

        $peminjaman->update([
            'status' => Peminjaman::STATUS_DITOLAK,
        ]);

        return response()->json([
            'message' => 'Peminjaman berhasil ditolak.',
            'data' => $peminjaman->fresh()->load(['anggota', 'buku']),
        ]);
    }

    public function storeSiswa(Request $request)
    {
        $anggota = $request->user()->anggota;

        if (!$anggota) {
            return response()->json([
                'message' => 'Akun siswa belum terhubung dengan data anggota.',
            ], 403);
        }

        $validated = $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_kembali' => 'nullable|date|after_or_equal:today',
        ]);

        $peminjaman = Peminjaman::create([
            'anggota_id' => $anggota->id,
            'buku_id' => $validated['buku_id'],
            'tanggal_pinjam' => now()->toDateString(),
            'tanggal_kembali' => $validated['tanggal_kembali'] ?? null,
            'status' => Peminjaman::STATUS_MENUNGGU,
        ]);

        return response()->json([
            'message' => 'Pengajuan peminjaman berhasil dikirim dan menunggu persetujuan petugas.',
            'data' => $peminjaman->load(['anggota', 'buku']),
        ], 201);
    }

    public function indexSiswa(Request $request)
    {
        $anggota = $request->user()->anggota;

        if (!$anggota) {
            return response()->json([
                'message' => 'Akun siswa belum terhubung dengan data anggota.'
            ], 403);
        }

        $query = $anggota->peminjaman();

        $statistik = [
            'menunggu' => (clone $query)
                ->where('status', 'menunggu')
                ->count(),

            'disetujui' => (clone $query)
                ->where('status', 'disetujui')
                ->count(),

            'ditolak' => (clone $query)
                ->where('status', 'ditolak')
                ->count(),
        ];

        $peminjaman = (clone $query)
            ->with('buku')
            ->latest()
            ->paginate(10);

        return response()->json(array_merge(
            $peminjaman->toArray(),
            ['statistik' => $statistik]
        ));
    }

    public function riwayatSiswa(Request $request)
    {
        $anggota = $request->user()->anggota;

        if (!$anggota) {
            return response()->json([
                'message' => 'Akun siswa belum terhubung dengan data anggota.'
            ], 403);
        }

        $riwayat = $anggota->peminjaman()
            ->with('buku')
            ->whereIn('status', ['disetujui', 'ditolak'])
            ->latest()
            ->paginate(10);

        return response()->json($riwayat);
    }
}
