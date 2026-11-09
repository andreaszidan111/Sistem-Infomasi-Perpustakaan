
@extends('layouts.petugas')

@section('title', 'Dashboard Petugas')

@section('content')
<!-- Header & Action Bar -->
<div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-white p-5 rounded-xl border border-[#E2E8F0] shadow-2xs">
    <div>
        <p class="text-[10px] font-semibold tracking-wider text-slate-400 uppercase">SIRKULASI & LAYANAN OPERASIONAL</p>
        <h1 class="text-xl font-bold text-[#0F172A] mt-0.5">Dashboard Petugas</h1>
        <p class="text-xs text-[#64748B]">Panel pelayanan sirkulasi buku, verifikasi anggota, dan peminjaman harian.</p>
    </div>
    <div class="flex items-center gap-2.5 flex-wrap">
        <a href="{{ route('petugas.peminjaman') }}" class="inline-flex items-center gap-1.5 bg-white border border-[#CBD5E1] hover:bg-slate-50 text-[#334155] px-3 py-1.5 rounded-lg text-xs font-medium transition shadow-2xs">
            Kelola Peminjaman
        </a>
        <a href="{{ route('petugas.pengembalian') }}" class="inline-flex items-center gap-1.5 bg-[#1E40AF] hover:bg-blue-800 text-white px-3.5 py-1.5 rounded-lg text-xs font-medium transition shadow-2xs">
            + Catat Pengembalian
        </a>
    </div>
</div>

<!-- Kartu Statistik -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Total Buku -->
    <div class="bg-white p-4 rounded-xl border border-[#E2E8F0] shadow-2xs flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between text-slate-500 mb-1">
                <span class="text-xs font-medium">Total Koleksi Buku</span>
                <span class="p-1.5 bg-blue-50 text-blue-700 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 7v14"/>
                        <path d="M3 18V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v13"/>
                        <path d="M3 18a3 3 0 0 0 3 3h15"/>
                        <path d="M3 18a3 3 0 0 1 3-3h15"/>
                    </svg>
                </span>
            </div>
            <h2 class="text-2xl font-bold text-[#0F172A] tracking-tight tabular-nums">
                {{ number_format($jumlahBuku, 0, ',', '.') }}
            </h2>
        </div>
        <p class="text-[11px] text-blue-700 font-medium mt-3">Jumlah seluruh koleksi buku</p>
    </div>

    <!-- Peminjaman Aktif -->
    <div class="bg-white p-4 rounded-xl border border-[#E2E8F0] shadow-2xs flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between text-slate-500 mb-1">
                <span class="text-xs font-medium">Peminjaman Aktif</span>
                <span class="p-1.5 bg-emerald-50 text-emerald-600 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 12a9 9 0 0 1 15.36-6.36L21 8"/>
                        <path d="M21 3v5h-5"/>
                        <path d="M21 12a9 9 0 0 1-15.36 6.36L3 16"/>
                        <path d="M3 21v-5h5"/>
                    </svg>
                </span>
            </div>
            <h2 class="text-2xl font-bold text-[#0F172A] tracking-tight tabular-nums">
                {{ number_format($peminjamanAktif, 0, ',', '.') }}
            </h2>
        </div>
        <p class="text-[11px] text-emerald-600 font-medium mt-3">Belum dikembalikan</p>
    </div>

    <!-- Antrean Menunggu -->
    <div class="bg-white p-4 rounded-xl border border-[#E2E8F0] shadow-2xs flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between text-slate-500 mb-1">
                <span class="text-xs font-medium">Antrean Menunggu</span>
                <span class="p-1.5 bg-sky-50 text-sky-600 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 6v6l4 2"/>
                    </svg>
                </span>
            </div>
            <h2 class="text-2xl font-bold text-[#0F172A] tracking-tight tabular-nums">
                {{ number_format($antreanMenunggu, 0, ',', '.') }}
            </h2>
        </div>
        <p class="text-[11px] text-blue-600 font-medium mt-3">Perlu persetujuan</p>
    </div>

    <!-- Buku Terlambat -->
    <div class="bg-white p-4 rounded-xl border border-[#E2E8F0] shadow-2xs flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between text-slate-500 mb-1">
                <span class="text-xs font-medium">Buku Terlambat</span>
                <span class="p-1.5 bg-red-50 text-red-600 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m10.29 3.86-8.1 14.02A2 2 0 0 0 3.93 21h16.14a2 2 0 0 0 1.74-3.12l-8.1-14.02a2 2 0 0 0-3.42 0Z"/>
                        <path d="M12 9v4"/>
                        <path d="M12 17h.01"/>
                    </svg>
                </span>
            </div>
            <h2 class="text-2xl font-bold text-red-600 tracking-tight tabular-nums">
                {{ number_format($bukuTerlambat, 0, ',', '.') }}
            </h2>
        </div>
        <p class="text-[11px] text-red-600 font-medium mt-3">Melewati tanggal jatuh tempo</p>
    </div>
</div>

<!-- Tabel Peminjaman Terbaru -->
<div class="bg-white rounded-xl border border-[#E2E8F0] shadow-2xs p-5 space-y-4">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
        <div>
            <h3 class="text-sm font-bold text-[#0F172A]">Antrean Peminjaman & Sirkulasi Terbaru</h3>
            <p class="text-xs text-slate-500 mt-1">Menampilkan 5 transaksi terbaru.</p>
        </div>
        <a href="{{ route('petugas.peminjaman') }}" class="text-xs font-medium text-blue-700 hover:underline">
            Lihat Semua →
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-[#0F172A]">
            <thead class="bg-slate-50 border-b border-slate-200 text-[10px] text-slate-500 uppercase tracking-wider font-semibold">
                <tr>
                    <th class="px-3 py-3">ID Transaksi</th>
                    <th class="px-3 py-3">Peminjam</th>
                    <th class="px-3 py-3">Judul Buku</th>
                    <th class="px-3 py-3">Tanggal Pinjam</th>
                    <th class="px-3 py-3">Status</th>
                    <th class="px-3 py-3 text-right">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
                @forelse ($peminjamanTerbaru as $item)
                    @php
                        $status = $item->status ?? 'menunggu';

                        $warnaStatus = [
                            'menunggu' => 'bg-amber-50 text-amber-700 border-amber-200',
                            'disetujui' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'ditolak' => 'bg-red-50 text-red-700 border-red-200',
                        ];

                        $labelStatus = [
                            'menunggu' => 'Menunggu',
                            'disetujui' => 'Disetujui',
                            'ditolak' => 'Ditolak',
                        ];
                    @endphp

                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-3 py-3 font-mono font-medium text-slate-700">
                            PJ-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}
                        </td>

                        <td class="px-3 py-3 font-bold text-slate-900">
                            {{ $item->anggota->nama ?? '-' }}
                        </td>

                        <td class="px-3 py-3 font-medium">
                            {{ $item->buku->judul ?? '-' }}
                        </td>

                        <td class="px-3 py-3 text-slate-600">
                            {{ $item->tanggal_pinjam ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d-m-Y') : '-' }}
                        </td>

                        <td class="px-3 py-3">
                            <span class="inline-flex px-2 py-0.5 border rounded-full text-[10px] font-semibold {{ $warnaStatus[$status] ?? 'bg-slate-50 text-slate-600 border-slate-200' }}">
                                {{ $labelStatus[$status] ?? $status }}
                            </span>
                        </td>

                        <td class="px-3 py-3 text-right">
                            <a href="{{ route('petugas.peminjaman') }}" class="inline-flex px-2.5 py-1 bg-blue-700 hover:bg-blue-800 text-white rounded text-[11px] font-medium transition">
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-3 py-8 text-center text-slate-500">
                            <div class="flex flex-col items-center gap-2">
                                <span class="text-2xl">📭</span>
                                <span>Belum ada transaksi peminjaman.</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
