@extends('layouts.petugas')

@section('title', 'Pencatatan Pengembalian & Denda')

@section('content')
<div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-white p-5 rounded-xl border border-[#E2E8F0] shadow-2xs">
    <div>
        <p class="text-[10px] font-semibold tracking-wider text-slate-400 uppercase">MODUL SIRKULASI AKADEMIK</p>
        <h1 class="text-xl font-bold text-[#0F172A] mt-0.5">Data Pengembalian & Perhitungan Denda</h1>
        <p class="text-xs text-[#64748B]">Pencatatan sirkulasi pengembalian fisik, inspeksi kondisi eksemplar, dan perhitungan denda keterlambatan.</p>
    </div>
    <div class="flex items-center gap-2.5 flex-wrap">
        <button type="button" id="tombol-refresh" class="inline-flex items-center gap-1.5 bg-white border border-[#CBD5E1] hover:bg-slate-50 text-[#334155] px-3 py-1.5 rounded-lg text-xs font-medium transition shadow-2xs">
            Muat Ulang Data
        </button>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
    <!-- Tabel transaksi -->
    <div class="lg:col-span-2 bg-white rounded-xl border border-[#E2E8F0] shadow-2xs p-5 space-y-4">
        <div class="flex items-center justify-between gap-3">
            <h3 class="text-sm font-bold text-[#0F172A]">Tabel Sirkulasi Pengembalian</h3>
            <span id="jumlah-data" class="text-xs text-slate-500">Memuat data...</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-[#0F172A]">
                <thead class="bg-slate-50 border-b border-slate-200 text-[10px] text-slate-500 uppercase tracking-wider font-semibold">
                    <tr>
                        <th class="px-3 py-2.5">ID</th>
                        <th class="px-3 py-2.5">Peminjam</th>
                        <th class="px-3 py-2.5">Buku</th>
                        <th class="px-3 py-2.5">Tgl Pinjam</th>
                        <th class="px-3 py-2.5">Batas Kembali</th>
                        <th class="px-3 py-2.5">Aksi</th>
                    </tr>
                </thead>
                <tbody id="daftar-pengembalian" class="divide-y divide-slate-100">
                    <tr>
                        <td colspan="6" class="px-3 py-6 text-center text-slate-500">Memuat data transaksi...</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p id="pesan-tabel" class="text-xs text-slate-500"></p>
    </div>

    <!-- Form pengembalian -->
    <div class="bg-white rounded-xl border border-[#E2E8F0] shadow-2xs p-5 space-y-4">
        <div>
            <span class="text-[10px] font-semibold tracking-wider text-slate-400 uppercase">PENCATATAN FISIK</span>
            <h3 class="text-sm font-bold text-[#0F172A] mt-0.5">Proses Pengembalian Cepat</h3>
            <p class="text-xs text-slate-500 mt-1">Pilih transaksi pada tabel untuk memproses pengembalian.</p>
        </div>

        <form id="form-pengembalian" class="space-y-3 text-xs">
            <input type="hidden" id="peminjaman_id">

            <div>
                <label class="block font-semibold text-slate-700 mb-1">Peminjam</label>
                <input type="text" id="nama-anggota" placeholder="Belum ada transaksi dipilih" class="w-full bg-slate-50 border border-slate-300 rounded px-3 py-1.5 text-slate-900" readonly>
            </div>

            <div>
                <label class="block font-semibold text-slate-700 mb-1">Email Anggota</label>
                <input type="text" id="email-anggota" placeholder="-" class="w-full bg-slate-50 border border-slate-300 rounded px-3 py-1.5 text-slate-900" readonly>
            </div>

            <div>
                <label class="block font-semibold text-slate-700 mb-1">Judul Buku</label>
                <input type="text" id="judul-buku" placeholder="-" class="w-full bg-slate-50 border border-slate-300 rounded px-3 py-1.5 text-slate-900" readonly>
            </div>

            <div>
                <label class="block font-semibold text-slate-700 mb-1">Batas Pengembalian</label>
                <input type="text" id="batas-kembali" placeholder="-" class="w-full bg-slate-50 border border-slate-300 rounded px-3 py-1.5 text-slate-900" readonly>
            </div>

            <div>
                <label for="kondisi-buku" class="block font-semibold text-slate-700 mb-1">Kondisi Fisik Buku</label>
                <select id="kondisi-buku" class="w-full bg-slate-50 border border-slate-300 rounded px-3 py-1.5 text-slate-800" disabled>
                    <option value="Baik">Baik</option>
                    <option value="Rusak Ringan">Rusak Ringan</option>
                    <option value="Rusak Berat">Rusak Berat</option>
                    <option value="Hilang">Hilang</option>
                </select>
            </div>

            <!-- Rincian denda -->
            <div class="p-3 bg-red-50/50 rounded-lg border border-red-200 space-y-2">
                <p class="text-[11px] font-bold text-red-700 uppercase">Rincian Tagihan Denda</p>
                <div class="flex justify-between gap-2 text-slate-700">
                    <span>Keterlambatan (<span id="hari-terlambat">0</span> hari)</span>
                    <span id="denda-terlambat" class="font-mono font-semibold">Rp0</span>
                </div>
                <div class="flex justify-between gap-2 text-slate-700">
                    <span>Denda kondisi buku</span>
                    <span id="denda-kondisi" class="font-mono font-semibold">Rp0</span>
                </div>
                <div class="flex justify-between border-t border-red-200 pt-2 text-red-700 font-bold text-sm">
                    <span>Total Denda</span>
                    <span id="total-denda" class="font-mono">Rp0</span>
                </div>
            </div>

            <p id="pesan-pengembalian" class="text-xs"></p>

            <button type="submit" id="tombol-submit" disabled class="w-full bg-[#1E40AF] hover:bg-blue-800 disabled:bg-slate-400 disabled:cursor-not-allowed text-white font-semibold py-2 rounded-lg transition shadow-2xs">
                Konfirmasi Pengembalian
            </button>
        </form>
    </div>
</div>

@vite('resources/js/pengembalian.js')
@endsection
