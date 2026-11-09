
@extends('layouts.siswa')

@section('title', 'Status Peminjaman')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-5 rounded-xl border border-[#E2E8F0]">
        <div>
            <h1 class="text-lg font-bold text-slate-800">Status Peminjaman</h1>
            <p class="text-sm text-slate-500 mt-1">
                Pantau status pengajuan peminjaman buku Anda.
            </p>
        </div>

        <a href="{{ route('siswa.peminjaman') }}"
           class="px-4 py-2.5 rounded-lg bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700">
            + Ajukan Peminjaman
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white border border-slate-200 rounded-xl p-5">
            <p class="text-sm text-slate-500">Menunggu</p>
            <h2 id="jumlah-menunggu" class="text-2xl font-bold text-amber-600 mt-2">0</h2>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl p-5">
            <p class="text-sm text-slate-500">Disetujui</p>
            <h2 id="jumlah-disetujui" class="text-2xl font-bold text-emerald-600 mt-2">0</h2>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl p-5">
            <p class="text-sm text-slate-500">Ditolak</p>
            <h2 id="jumlah-ditolak" class="text-2xl font-bold text-red-600 mt-2">0</h2>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
        <div class="p-5 border-b border-slate-200">
            <h2 class="font-bold text-slate-800">Daftar Pengajuan</h2>
            <p class="text-xs text-slate-500 mt-1">
                Daftar pengajuan peminjaman yang pernah Anda lakukan.
            </p>
        </div>

        <div id="pesan-status" class="hidden p-4 text-sm"></div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                    <tr>
                        <th class="px-5 py-4">No.</th>
                        <th class="px-5 py-4">Judul Buku</th>
                        <th class="px-5 py-4">Tanggal Pengajuan</th>
                        <th class="px-5 py-4">Tanggal Kembali</th>
                        <th class="px-5 py-4">Status</th>
                    </tr>
                </thead>

                <tbody id="daftar-peminjaman" class="divide-y divide-slate-100">
                    <tr>
                        <td colspan="5" class="text-center py-8 text-slate-400">
                            Memuat data peminjaman...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex items-center justify-between gap-3 p-5 border-t border-slate-200">
            <p id="info-halaman" class="text-xs text-slate-500">Halaman 1</p>

            <div class="flex gap-2">
                <button id="halaman-sebelumnya"
                    class="px-3 py-2 text-xs border border-slate-200 rounded-lg disabled:opacity-40"
                    disabled>
                    Sebelumnya
                </button>

                <button id="halaman-selanjutnya"
                    class="px-3 py-2 text-xs border border-slate-200 rounded-lg disabled:opacity-40"
                    disabled>
                    Selanjutnya
                </button>
            </div>
        </div>
    </div>
</div>
@vite('resources/js/siswa-status-peminjaman.js')

@endsection