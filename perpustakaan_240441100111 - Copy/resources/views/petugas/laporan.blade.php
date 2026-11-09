@extends('layouts.petugas')

@section('title', 'Laporan Analitik Perpustakaan')

@section('content')
<div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-white p-5 rounded-xl border border-[#E2E8F0] shadow-2xs">
    <div>
        <p class="text-[10px] font-semibold tracking-wider text-slate-400 uppercase">MODUL EKSEKUTIF • SIPERPUS CORE</p>
        <h1 class="text-xl font-bold text-[#0F172A] mt-0.5">Laporan Perpustakaan</h1>
        <p class="text-xs text-[#64748B]">Pusat analitik sirkulasi dan pengembalian perpustakaan.</p>
    </div>
    <div class="flex items-center gap-2.5 flex-wrap">
        <button type="button" id="tombol-cetak" class="bg-blue-700 hover:bg-blue-800 text-white px-3.5 py-1.5 rounded-lg text-xs font-medium inline-flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect>
            </svg>
            Print Laporan
        </button>
    </div>
</div>

<!-- FILTER PERIODE -->
<div class="bg-white p-4 rounded-xl border border-[#E2E8F0] shadow-2xs flex flex-wrap items-end justify-between gap-4">
    <div class="flex items-center gap-3 flex-wrap text-xs">
        <div>
            <label for="tanggal-mulai" class="block text-[10px] font-semibold text-slate-400 uppercase mb-1">Tanggal Mulai</label>
            <input type="date" id="tanggal-mulai" class="bg-slate-50 border border-slate-200 rounded px-3 py-1.5">
        </div>
        <div>
            <label for="tanggal-selesai" class="block text-[10px] font-semibold text-slate-400 uppercase mb-1">Tanggal Selesai</label>
            <input type="date" id="tanggal-selesai" class="bg-slate-50 border border-slate-200 rounded px-3 py-1.5">
        </div>
    </div>
    <div class="flex gap-2">
        <button type="button" id="tombol-filter" class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-1.5 rounded-lg text-xs font-medium">Terapkan Filter</button>
        <button type="button" id="tombol-reset" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-1.5 rounded-lg text-xs font-medium">Reset</button>
    </div>
</div>

<!-- RINGKASAN -->
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
    <div class="bg-white p-5 rounded-xl border border-slate-200">
        <p class="text-xs text-slate-500">Total Peminjaman</p>
        <h2 id="total-peminjaman" class="text-2xl font-bold text-slate-900 mt-2">0</h2>
    </div>
    <div class="bg-white p-5 rounded-xl border border-slate-200">
        <p class="text-xs text-slate-500">Total Pengembalian</p>
        <h2 id="total-pengembalian" class="text-2xl font-bold text-emerald-600 mt-2">0</h2>
    </div>
    <div class="bg-white p-5 rounded-xl border border-slate-200">
        <p class="text-xs text-slate-500">Peminjaman Aktif</p>
        <h2 id="peminjaman-aktif" class="text-2xl font-bold text-blue-700 mt-2">0</h2>
    </div>
    <div class="bg-white p-5 rounded-xl border border-slate-200">
        <p class="text-xs text-slate-500">Peminjaman Terlambat</p>
        <h2 id="peminjaman-terlambat" class="text-2xl font-bold text-red-600 mt-2">0</h2>
    </div>
    <div class="bg-white p-5 rounded-xl border border-slate-200">
        <p class="text-xs text-slate-500">Denda Keterlambatan</p>
        <h2 id="denda-keterlambatan" class="text-2xl font-bold text-slate-900 mt-2">Rp0</h2>
    </div>
    <div class="bg-white p-5 rounded-xl border border-slate-200">
        <p class="text-xs text-slate-500">Total Denda</p>
        <h2 id="total-denda" class="text-2xl font-bold text-red-600 mt-2">Rp0</h2>
    </div>
</div>

<!-- REKAP BUKU -->
<div class="bg-white rounded-xl border border-[#E2E8F0] shadow-2xs p-5 space-y-4">
    <div class="flex items-center justify-between">
        <h3 class="text-sm font-bold text-[#0F172A]">Rekapitulasi Sirkulasi Koleksi Buku</h3>
        <span id="jumlah-buku" class="text-xs text-slate-500">0 buku</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-[#0F172A]">
            <thead class="bg-slate-50 border-b border-slate-200 text-[10px] text-slate-500 uppercase tracking-wider font-semibold">
                <tr>
                    <th class="px-4 py-3">Judul Buku</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Total Dipinjam</th>
                    <th class="px-4 py-3">Dikembalikan</th>
                    <th class="px-4 py-3">Terlambat</th>
                </tr>
            </thead>
            <tbody id="daftar-rekap-buku" class="divide-y divide-slate-100">
                <tr><td colspan="5" class="px-4 py-6 text-center text-slate-500">Memuat data...</td></tr>
            </tbody>
        </table>
    </div>
</div>

<!-- DETAIL TRANSAKSI -->
<div class="bg-white rounded-xl border border-[#E2E8F0] shadow-2xs p-5 space-y-4">
    <div class="flex items-center justify-between">
        <h3 class="text-sm font-bold text-[#0F172A]">Detail Transaksi Peminjaman</h3>
        <span id="jumlah-transaksi" class="text-xs text-slate-500">0 transaksi</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 border-b border-slate-200 text-[10px] text-slate-500 uppercase">
                <tr>
                    <th class="px-3 py-3">ID</th>
                    <th class="px-3 py-3">Anggota</th>
                    <th class="px-3 py-3">Buku</th>
                    <th class="px-3 py-3">Tanggal Pinjam</th>
                    <th class="px-3 py-3">Batas Kembali</th>
                    <th class="px-3 py-3">Tanggal Dikembalikan</th>
                    <th class="px-3 py-3">Kondisi</th>
                    <th class="px-3 py-3">Total Denda</th>
                </tr>
            </thead>
            <tbody id="daftar-transaksi" class="divide-y divide-slate-100">
                <tr><td colspan="8" class="px-3 py-6 text-center text-slate-500">Memuat data...</td></tr>
            </tbody>
        </table>
    </div>
</div>

<p id="pesan-laporan" class="text-xs text-slate-500"></p>

@vite('resources/js/laporan.js')
@endsection
