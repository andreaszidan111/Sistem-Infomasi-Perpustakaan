@extends('layouts.admin')

@section('title', 'Kelola Buku & Katalog')

@section('content')
<!-- Top Header & Action Bar -->
<div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-white p-5 rounded-xl border border-[#E2E8F0] shadow-2xs">
    <div>
        <p class="text-[10px] font-semibold tracking-wider text-slate-400 uppercase">MANAJEMEN DATA & KATALOG BUKU</p>
        <h1 class="text-xl font-bold text-[#0F172A] mt-0.5">Data Buku</h1>
    </div>
    <div class="flex items-center gap-2.5 flex-wrap">
        @can('kelola buku')
        <button type="button" id="tombol-tambah-buku" class="inline-flex items-center gap-1.5 bg-[#1E40AF] hover:bg-blue-800 text-white px-3.5 py-1.5 rounded-lg text-xs font-medium transition shadow-2xs">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Buku Baru
        </button>
        @endcan
    </div>
</div>

<!-- Form Tambah / Edit Buku -->
@can('kelola buku')
<div id="form-container" class="hidden bg-white rounded-xl border border-[#E2E8F0] shadow-2xs p-5 mt-4">
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 id="judul-form" class="text-base font-bold text-[#0F172A]">Tambah Buku</h2>
            <p class="text-xs text-slate-500 mt-1">Masukkan data buku yang akan ditambahkan ke katalog.</p>
        </div>
        <button type="button" id="tombol-tutup-form" class="text-slate-400 hover:text-slate-700 text-lg">×</button>
    </div>

    <form id="form-buku" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="kategori_id" class="block text-xs font-medium text-slate-700 mb-1.5">Kategori</label>
            <input type="number" id="kategori_id" name="kategori_id" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-700" placeholder="Masukkan ID kategori" required>
        </div>

        <div>
            <label for="judul" class="block text-xs font-medium text-slate-700 mb-1.5">Judul Buku</label>
            <input type="text" id="judul" name="judul" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-700" placeholder="Masukkan judul buku" required>
        </div>

        <div>
            <label for="penulis" class="block text-xs font-medium text-slate-700 mb-1.5">Penulis</label>
            <input type="text" id="penulis" name="penulis" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-700" placeholder="Masukkan nama penulis" required>
        </div>

        <div>
            <label for="tahun_terbit" class="block text-xs font-medium text-slate-700 mb-1.5">Tahun Terbit</label>
            <input type="number" id="tahun_terbit" name="tahun_terbit" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-700" placeholder="Contoh: 2024" required>
        </div>

        <div>
            <label for="stok" class="block text-xs font-medium text-slate-700 mb-1.5">Stok</label>
            <input type="number" id="stok" name="stok" min="0" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-700" placeholder="Jumlah buku tersedia" required>
        </div>

        <div class="md:col-span-2 flex items-center gap-2 pt-2">
            <button type="submit" id="tombol-submit" class="bg-[#1E40AF] hover:bg-blue-800 text-white px-4 py-2 rounded-lg text-xs font-medium">Tambah Buku</button>
            <button type="button" id="tombol-batal" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-lg text-xs font-medium">Batal</button>
        </div>
    </form>

    <div id="pesan-buku" class="mt-4"></div>
</div>    
@endcan

<!-- TABEL UTAMA KATALOG BUKU -->
<div class="bg-white rounded-xl border border-[#E2E8F0] shadow-2xs p-5 space-y-4">
    <!-- Tabel Data Buku -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-[#0F172A]">
            <thead class="bg-slate-50 border-b border-slate-200 text-[10px] text-slate-500 uppercase tracking-wider font-semibold">
                <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Tahun</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody id="tabel-buku" class="divide-y divide-slate-100">
                <tr>
                    <td colspan="7" class="px-4 py-6 text-center text-slate-500">
                        Memuat data buku...
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
        <span>
            Baris per halaman:
            <select id="jumlah-per-halaman" class="bg-slate-50 border border-slate-200 rounded px-2 py-0.5 text-xs text-slate-700">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </span>

        <div class="flex items-center gap-1">
            <button id="halaman-sebelumnya" class="px-2 py-1 bg-slate-100 rounded">Sebelumnya</button>
            <span id="info-halaman" class="px-2 py-1 bg-blue-700 text-white rounded font-medium">1</span>
            <button id="halaman-selanjutnya" class="px-2 py-1 bg-slate-100 rounded">Selanjutnya</button>
        </div>
    </div>
</div>
@vite('resources/js/buku.js')
@endsection