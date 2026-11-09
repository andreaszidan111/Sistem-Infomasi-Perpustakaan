<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use App\Models\Buku;
use Illuminate\Http\Request;
use App\Http\Resources\BukuResource;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->input('per_page', 10), 1), 100);
        $buku = buku::with('kategori')
            ->withCount('peminjaman')
            ->when($request->filled('cari'), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('judul', 'like', '%' . $request->cari . '%')
                    ->orWhere('penulis', 'like', '%' . $request->cari . '%');
                });
            })
            ->when($request->filled('kategori'), function ($query) use ($request) {
                $query->where('kategori_id', $request->kategori);
            })
            ->when($request->filled('tahun'), function ($query) use ($request) {
                $query->where('tahun_terbit', $request->tahun);
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return response()->json([
            'data' => BukuResource::collection($buku->items()),
            'meta' => [
                'current_page' => $buku->currentPage(),
                'last_page' => $buku->lastPage(),
                'per_page' => $buku->perPage(),
                'total' => $buku->total(),
            ],
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBukuRequest $request)
    {
        $buku = buku::create($request->validated());

        $buku->load('kategori');

        return response()->json([
            'message' => 'Buku berhasil ditambahkan.',
            'data' => $buku,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $buku = buku::with(['kategori', 'peminjaman'])->find($id);

        if (!$buku) {
            return response()->json([
                'message' => 'Not found'
            ], 404);
        }

        return response()->json([
            'data' => new BukuResource($buku)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBukuRequest $request, buku $buku)
    {
        $buku->update($request->validated());

        $buku->load('kategori');

        return response()->json([
            'message' => 'Buku berhasil diperbarui.',
            'data' => $buku,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(buku $buku)
    {
        $buku->delete();

        return response()->json([
            'message' => 'Buku berhasil dihapus',
        ], 200);
    }

    public function bukuPerKategori()
    {
        $rekap = buku::selectRaw('kategori_id, COUNT(*) as jumlah_buku')
            ->with('kategori')
            ->groupBy('kategori_id')
            ->get();

        return response()->json([
            'data' => $rekap
        ], 200);
    }

    public function peminjamanPerBuku()
    {
        $rekap = buku::withCount('peminjaman')
            ->with('kategori')
            ->get();

        return response()->json([
            'data' => $rekap
        ], 200);
    }

    public function cariRentan(Request $request)
    {
        $judul = $request->query('judul');

        $hasil = DB::select(
            "SELECT * FROM bukus WHERE judul = '$judul'"
        );

        return response()->json($hasil);
    }
}