
@extends('layouts.siswa')

@section('title', 'Riwayat Peminjaman')

@section('content')
<div class="space-y-6">

    <div class="bg-white p-5 rounded-xl border border-slate-200">
        <h1 class="text-lg font-bold text-slate-800">Riwayat Peminjaman</h1>
        <p class="text-sm text-slate-500 mt-1">
            Lihat daftar peminjaman yang telah selesai dan pengajuan yang ditolak.
        </p>
    </div>

    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">

        <div class="p-5 border-b border-slate-200">
            <h2 class="font-bold text-slate-800">Daftar Riwayat</h2>
            <p class="text-xs text-slate-500 mt-1">
                Riwayat peminjaman berdasarkan akun Anda.
            </p>
        </div>

        <div id="pesan-riwayat" class="hidden p-4 text-sm"></div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                    <tr>
                        <th class="px-5 py-4">No.</th>
                        <th class="px-5 py-4">Judul Buku</th>
                        <th class="px-5 py-4">Tanggal Pinjam</th>
                        <th class="px-5 py-4">Batas Kembali</th>
                        <th class="px-5 py-4">Dikembalikan</th>
                        <th class="px-5 py-4">Status</th>
                    </tr>
                </thead>

                <tbody id="daftar-riwayat" class="divide-y divide-slate-100">
                    <tr>
                        <td colspan="6" class="text-center py-8 text-slate-400">
                            Memuat riwayat peminjaman...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex items-center justify-between gap-3 p-5 border-t border-slate-200">
            <p id="info-halaman-riwayat" class="text-xs text-slate-500">
                Halaman 1
            </p>

            <div class="flex gap-2">
                <button id="riwayat-sebelumnya"
                    class="px-3 py-2 text-xs border border-slate-200 rounded-lg disabled:opacity-40"
                    disabled>
                    Sebelumnya
                </button>

                <button id="riwayat-selanjutnya"
                    class="px-3 py-2 text-xs border border-slate-200 rounded-lg disabled:opacity-40"
                    disabled>
                    Selanjutnya
                </button>
            </div>
        </div>
    </div>
</div>
@vite('resources/js/siswa-riwayat.js')
@endsection