@extends('layouts.siswa')

@section('title', 'Katalog Buku')

@section('content')

<!-- Header Katalog -->
<div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-white p-5 rounded-xl border border-[#E2E8F0] shadow-2xs">
    <div>
        <p class="text-[10px] font-semibold tracking-wider text-slate-400 uppercase">
            KOLEKSI & INFORMASI PERPUSTAKAAN
        </p>
        <h1 class="text-xl font-bold text-[#0F172A] mt-0.5">
            Katalog Buku
        </h1>
        <p class="text-xs text-slate-500 mt-1">
            Temukan buku yang ingin kamu baca atau pinjam.
        </p>
    </div>

    <a href="{{ route('siswa.peminjaman') }}"
       class="inline-flex items-center justify-center gap-2 bg-[#1E40AF] hover:bg-blue-800 text-white px-4 py-2 rounded-lg text-xs font-medium transition">
        Ajukan Peminjaman
    </a>
</div>

<!-- Pencarian dan Filter -->
<div class="bg-white rounded-xl border border-[#E2E8F0] shadow-2xs p-5 mt-4">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">

        <div class="md:col-span-2">
            <label for="cari-buku" class="block text-xs font-medium text-slate-700 mb-1.5">
                Cari Buku
            </label>

            <input
                type="text"
                id="cari-buku"
                placeholder="Cari berdasarkan judul atau penulis..."
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-700"
            >
        </div>

        <div>
            <label for="filter-kategori" class="block text-xs font-medium text-slate-700 mb-1.5">
                Kategori Buku
            </label>

            <select
                id="filter-kategori"
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-700"
            >
                <option value="">Semua Kategori</option>

                @foreach ($kategori as $item)
                    <option value="{{ $item->id }}">
                        {{ $item->nama }}
                    </option>
                @endforeach
            </select>
        </div>

    </div>

    <div class="flex justify-between items-center mt-3">
        <p id="jumlah-buku" class="text-xs text-slate-500">
            Memuat katalog...
        </p>

        <button
            type="button"
            id="reset-filter"
            class="text-xs text-blue-700 hover:text-blue-900 font-medium"
        >
            Reset Filter
        </button>
    </div>
</div>

<!-- Tabel Katalog -->
<div class="bg-white rounded-xl border border-[#E2E8F0] shadow-2xs p-5 mt-4 space-y-4">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-sm font-bold text-[#0F172A]">
                Daftar Koleksi Buku
            </h2>
            <p class="text-xs text-slate-500 mt-1">
                Informasi koleksi buku yang tersedia di perpustakaan.
            </p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-[#0F172A]">
            <thead class="bg-slate-50 border-b border-slate-200 text-[10px] text-slate-500 uppercase tracking-wider font-semibold">
                <tr>
                    <th class="px-4 py-3">No</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Judul Buku</th>
                    <th class="px-4 py-3">Penulis</th>
                    <th class="px-4 py-3">Tahun</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody id="tabel-buku" class="divide-y divide-slate-100">
                <tr>
                    <td colspan="6" class="px-4 py-6 text-center text-slate-500">
                        Memuat data buku...
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pt-3 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">

        <div class="flex items-center gap-2">
            <span>Baris per halaman:</span>

            <select
                id="jumlah-per-halaman"
                class="bg-slate-50 border border-slate-200 rounded px-2 py-1 text-xs text-slate-700"
            >
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </div>

        <div class="flex items-center gap-2">
            <button
                type="button"
                id="halaman-sebelumnya"
                class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 rounded disabled:opacity-40"
                disabled
            >
                Sebelumnya
            </button>

            <span id="info-halaman" class="px-3 py-1.5 bg-blue-700 text-white rounded font-medium">
                1 / 1
            </span>

            <button
                type="button"
                id="halaman-selanjutnya"
                class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 rounded disabled:opacity-40"
                disabled
            >
                Selanjutnya
            </button>
        </div>
    </div>
</div>

<!-- Modal Detail Buku -->
<div id="modal-detail-buku"
     class="hidden fixed inset-0 z-50 bg-slate-950/50 items-center justify-center p-4">

    <div class="bg-white w-full max-w-lg rounded-xl shadow-xl overflow-hidden">

        <div class="flex items-center justify-between p-5 border-b border-slate-100">
            <div>
                <p class="text-[10px] uppercase tracking-wider font-semibold text-slate-400">
                    INFORMASI KOLEKSI
                </p>
                <h2 class="text-base font-bold text-slate-900 mt-1">
                    Detail Buku
                </h2>
            </div>

            <button
                type="button"
                id="tutup-detail-buku"
                class="text-slate-400 hover:text-slate-700 text-2xl"
                aria-label="Tutup"
            >
                &times;
            </button>
        </div>

        <div class="p-5 space-y-4">

            <div>
                <p class="text-[10px] uppercase text-slate-400 font-semibold">
                    Judul Buku
                </p>
                <p id="detail-judul" class="text-lg font-bold text-slate-900 mt-1">
                    -
                </p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-[10px] uppercase text-slate-400 font-semibold">
                        Kategori
                    </p>
                    <p id="detail-kategori" class="text-sm font-medium text-slate-700 mt-1">
                        -
                    </p>
                </div>

                <div>
                    <p class="text-[10px] uppercase text-slate-400 font-semibold">
                        Tahun Terbit
                    </p>
                    <p id="detail-tahun" class="text-sm font-medium text-slate-700 mt-1">
                        -
                    </p>
                </div>
            </div>

            <div>
                <p class="text-[10px] uppercase text-slate-400 font-semibold">
                    Penulis
                </p>
                <p id="detail-penulis" class="text-sm font-medium text-slate-700 mt-1">
                    -
                </p>
            </div>

        </div>

        <div class="p-5 bg-slate-50 border-t border-slate-100 flex justify-end gap-2">
            <button
                type="button"
                id="tutup-detail-bawah"
                class="px-4 py-2 bg-white border border-slate-300 text-slate-700 rounded-lg text-xs font-medium hover:bg-slate-100"
            >
                Tutup
            </button>

            <a
                href="{{ route('siswa.peminjaman') }}"
                id="tombol-ajukan-dari-detail"
                class="px-4 py-2 bg-[#1E40AF] hover:bg-blue-800 text-white rounded-lg text-xs font-medium"
            >
                Ajukan Peminjaman
            </a>
        </div>

    </div>
</div>

@vite('resources/js/siswa-buku.js')

@endsection