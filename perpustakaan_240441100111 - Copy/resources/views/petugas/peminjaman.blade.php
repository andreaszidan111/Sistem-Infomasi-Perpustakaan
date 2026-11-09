@extends('layouts.petugas')

@section('title', 'Sirkulasi Peminjaman')

@section('content')
<!-- Top Header & Action Bar -->
<div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-white p-5 rounded-xl border border-[#E2E8F0] shadow-2xs">
    <div>
        <p class="text-[10px] font-semibold tracking-wider text-slate-400 uppercase">MODUL SIRKULASI AKADEMIK</p>
        <h1 class="text-xl font-bold text-[#0F172A] mt-0.5">Data Peminjaman Buku</h1>
        <p class="text-xs text-[#64748B]">Kelola permohonan pinjam, verifikasi ketersediaan stok, dan konfirmasi persetujuan transaksi.</p>
    </div>

    <div class="flex items-center gap-2.5 flex-wrap">
        <button id="tombol-tambah" type="button" href="#" class="inline-flex items-center gap-1.5 bg-[#1E40AF] hover:bg-blue-800 text-white px-3.5 py-1.5 rounded-lg text-xs font-medium transition shadow-2xs">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Transaksi Pinjam Baru
        </button>
    </div>
</div>

<!-- FORM TAMBAH / EDIT PEMINJAMAN -->
<div id="form-container" class="hidden bg-white rounded-xl border border-[#E2E8F0] shadow-2xs p-5 mt-4">
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 id="judul-form" class="text-base font-bold text-[#0F172A]">Tambah Peminjaman</h2>
            <p class="text-xs text-slate-500 mt-1">Masukkan data transaksi peminjaman buku.</p>
        </div>
        <button type="button" id="tombol-tutup-form" class="text-slate-400 hover:text-slate-700 text-lg">×</button>
    </div>

    <form id="form-peminjaman" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Anggota -->
        <div>
            <label for="anggota_id" class="block text-xs font-medium text-slate-700 mb-1.5">Nama Anggota</label>
            <select id="anggota_id" name="anggota_id" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-700" required>
                <option value="">Pilih Anggota</option>
            </select>
        </div>

        <!-- Buku -->
        <div>
            <label for="buku_id" class="block text-xs font-medium text-slate-700 mb-1.5">Judul Buku</label>
            <select id="buku_id" name="buku_id" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-700" required>
                <option value="">Pilih Buku</option>
            </select>
        </div>

        <!-- Tanggal Pinjam -->
        <div>
            <label for="tanggal_pinjam" class="block text-xs font-medium text-slate-700 mb-1.5">Tanggal Pinjam</label>
            <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-700" required>
        </div>

        <!-- Tanggal Kembali -->
        <div>
            <label for="tanggal_kembali" class="block text-xs font-medium text-slate-700 mb-1.5">Batas Kembali</label>
            <input type="date" id="tanggal_kembali" name="tanggal_kembali" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-700">
        </div>

        <!-- Tombol -->
        <div class="md:col-span-2 flex items-center gap-2 pt-2">
            <button type="submit" id="tombol-submit" class="bg-[#1E40AF] hover:bg-blue-800 text-white px-4 py-2 rounded-lg text-xs font-medium">Tambah Peminjaman</button>
            <button type="button" id="tombol-batal" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-lg text-xs font-medium">Batal</button>
        </div>
    </form>

    <div id="pesan-peminjaman" class="mt-4 text-xs"></div>
</div>
<!-- 4 KARTU METRIK PEMINJAMAN -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white p-4 rounded-xl border border-[#E2E8F0] shadow-2xs flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between text-slate-500 mb-1">
                <span class="text-xs font-medium">Total Transaksi</span>
                <span class="p-1.5 bg-sky-50 text-sky-600 rounded-md"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-receipt preview-icon"><path d="M12 17V7"/><path d="M16 8h-6a2 2 0 0 0 0 4h4a2 2 0 0 1 0 4H8"/><path d="M4 3a1 1 0 0 1 1-1 1.3 1.3 0 0 1 .7.2l.933.6a1.3 1.3 0 0 0 1.4 0l.934-.6a1.3 1.3 0 0 1 1.4 0l.933.6a1.3 1.3 0 0 0 1.4 0l.933-.6a1.3 1.3 0 0 1 1.4 0l.934.6a1.3 1.3 0 0 0 1.4 0l.933-.6A1.3 1.3 0 0 1 19 2a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1 1.3 1.3 0 0 1-.7-.2l-.933-.6a1.3 1.3 0 0 0-1.4 0l-.934.6a1.3 1.3 0 0 1-1.4 0l-.933-.6a1.3 1.3 0 0 0-1.4 0l-.933.6a1.3 1.3 0 0 1-1.4 0l-.934-.6a1.3 1.3 0 0 0-1.4 0l-.933.6a1.3 1.3 0 0 1-.7.2 1 1 0 0 1-1-1z"/></svg></span>
            </div>
            <h2 id="total-transaksi" class="text-2xl font-bold text-[#0F172A] tracking-tight tabular-nums">0</h2>
        </div>
        <p class="text-[11px] text-blue-700 font-medium mt-3">jumlah seluruh data peminjaman</p>
    </div>

    <div class="bg-white p-4 rounded-xl border border-[#E2E8F0] shadow-2xs flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between text-slate-500 mb-1">
                <span class="text-xs font-medium">Peminjaman Hari Ini</span>
                <span class="p-1.5 bg-emerald-50 text-emerald-600 rounded-md"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-plus preview-icon"><path d="M16 18h6"/><path d="M16 2v3"/><path d="M19 15v6"/><path d="M21 11.5V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2h8.3"/><path d="M3 9h18"/><path d="M8 2v3"/></svg></span>
            </div>
            <h2 id="peminjaman-hari-ini" class="text-2xl font-bold text-[#0F172A] tracking-tight tabular-nums">0</h2>
        </div>
        <p class="text-[11px] text-emerald-600 font-medium mt-3">Transaksi dengan tanggal pinjam hari ini</p>
    </div>

    <div class="bg-white p-4 rounded-xl border border-[#E2E8F0] shadow-2xs flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between text-slate-500 mb-1">
                <span class="text-xs font-medium">Jadwal Kembali Hari Ini</span>
                <span class="p-1.5 bg-amber-50 text-amber-600 rounded-md"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-x-2 preview-icon"><path d="M16 2v3"/><path d="m17 16 5 5"/><path d="m17 21 5-5"/><path d="M21 12V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2h8"/><path d="M3 9h18"/><path d="M8 2v3"/></svg></span>
            </div>
            <h2 id="jatuh-tempo-hari-ini" class="text-2xl font-bold text-amber-600 tracking-tight tabular-nums">0</h2>
        </div>
        <p class="text-[11px] text-amber-600 font-medium mt-3">Tanggal kembali yang jatuh hari ini</p>
    </div>

    <div class="bg-white p-4 rounded-xl border border-[#E2E8F0] shadow-2xs flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between text-slate-500 mb-1">
                <span class="text-xs font-medium">Jadwal Kembali Terlewat</span>
                <span class="p-1.5 bg-red-50 text-red-600 rounded-md"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></span>
            </div>
            <h2 id="lewat-jatuh-tempo" class="text-2xl font-bold text-red-600 tracking-tight tabular-nums">0</h2>
        </div>
        <p class="text-[11px] text-red-600 font-medium mt-3">Tanggal kembali sebelum hari ini</p>
    </div>
</div>

<!-- TABEL UTAMA PEMINJAMAN -->
<div class="bg-white rounded-xl border border-[#E2E8F0] shadow-2xs p-5 space-y-4">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
        <div class="flex items-center gap-2 flex-wrap">
            <input id="cari-peminjaman" type="text" placeholder="Cari nama anggota atau judul buku..." class="bg-slate-50 border border-slate-200 rounded-lg px-3 py-1.5 text-xs text-slate-800 w-64 focus:outline-none focus:border-blue-700">
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-[#0F172A]">
            <thead class="bg-slate-50 border-b border-slate-200 text-[10px] text-slate-500 uppercase tracking-wider font-semibold">
                <tr>
                    <th class="px-4 py-3">ID Transaksi</th>
                    <th class="px-4 py-3">Anggota</th>
                    <th class="px-4 py-3">Buku</th>
                    <th class="px-4 py-3">Tanggal Pinjam</th>
                    <th class="px-4 py-3">Tanggal Kembali</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody id="daftar-peminjaman">
                <tr>
                    <td colspan="6" class="px-4 py-6 text-center text-slate-500">Memuat data...</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 border-t border-slate-100 pt-4 mt-4">
        <p id="info-peminjaman" class="text-xs text-slate-500">Total 0 transaksi</p>
        <div class="flex items-center gap-2">
            <button type="button" id="tombol-sebelumnya" class="px-3 py-1.5 text-xs font-medium text-slate-500 bg-slate-100 rounded-md hover:bg-slate-200 disabled:opacity-50 disabled:cursor-not-allowed transition">Sebelumnya</button>
            <span id="nomor-halaman" class="px-3 py-1.5 text-xs font-semibold text-white bg-blue-700 rounded-md">1 / 1</span>
            <button type="button" id="tombol-selanjutnya" class="px-3 py-1.5 text-xs font-medium text-slate-500 bg-slate-100 rounded-md hover:bg-slate-200 disabled:opacity-50 disabled:cursor-not-allowed transition">Selanjutnya</button>
        </div>
    </div>
</div>
@vite('resources/js/peminjaman.js')
@endsection