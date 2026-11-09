@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<!-- Top Status & Action Bar -->
<div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-white p-5 rounded-xl border border-[#E2E8F0] shadow-xs">
    <div>
        <p class="text-[10px] font-semibold tracking-wider text-slate-400 uppercase">SIRKULASI & INVENTARIS KAMPUS • LIVE OPERATIONAL</p>
        <h1 class="text-xl font-bold text-[#0F172A] mt-0.5">Dashboard Admin</h1>
        <p class="text-xs text-[#64748B]">Kelola dan pantau seluruh aktivitas perpustakaan pusat secara komprehensif.</p>
    </div>

    <div class="flex items-center gap-2.5 flex-wrap">
        <a href="#" class="inline-flex items-center gap-1.5 bg-white border border-[#CBD5E1] hover:bg-slate-50 text-[#334155] px-3 py-1.5 rounded-lg text-xs font-medium transition shadow-2xs">
            <svg class="w-3.5 h-3.5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            Kelola Peminjaman
        </a>
        <a href="#" class="inline-flex items-center gap-1.5 bg-white border border-[#CBD5E1] hover:bg-slate-50 text-[#334155] px-3 py-1.5 rounded-lg text-xs font-medium transition shadow-2xs">
            <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            Lihat Laporan
        </a>
        <a href="#" class="inline-flex items-center gap-1.5 bg-white border border-[#CBD5E1] hover:bg-slate-50 text-[#334155] px-3 py-1.5 rounded-lg text-xs font-medium transition shadow-2xs">
            <svg class="w-3.5 h-3.5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            Tambah Pengguna
        </a>
        <a href="{{ route('admin.buku') }}" class="inline-flex items-center gap-1.5 bg-[#1E40AF] hover:bg-blue-800 text-white px-3.5 py-1.5 rounded-lg text-xs font-medium transition shadow-2xs">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Buku
        </a>
    </div>
</div>

<!-- 5 KARTU METRIK UTAMA ATAS -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
    <!-- Total Buku -->
    <div class="bg-white p-4 rounded-xl border border-[#E2E8F0] shadow-2xs flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between text-slate-500 mb-1">
                <span class="text-xs font-medium">Total Buku</span>
                <span class="p-1.5 bg-blue-50 text-blue-700 rounded-md"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg></span>
            </div>
            <h2 class="text-2xl font-bold text-[#0F172A] tracking-tight tabular-nums">{{ $jumlahBuku }}</h2>
        </div>
        <p class="text-[11px] text-blue-700 font-medium mt-3 flex items-center gap-1">Koleksi buku saat ini</p>
    </div>

    <!-- Total Pengguna -->
    <div class="bg-white p-4 rounded-xl border border-[#E2E8F0] shadow-2xs flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between text-slate-500 mb-1">
                <span class="text-xs font-medium">Total Pengguna</span>
                <span class="p-1.5 bg-indigo-50 text-indigo-700 rounded-md"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg></span>
            </div>
            <h2 class="text-2xl font-bold text-[#0F172A] tracking-tight tabular-nums">{{ $jumlahAnggota }}</h2>
        </div>
        <p class="text-[11px] text-blue-700 font-medium mt-3 flex items-center gap-1">Total anggota terdaftar</p>
    </div>

    <!-- Peminjaman Aktif -->
    <div class="bg-white p-4 rounded-xl border border-[#E2E8F0] shadow-2xs flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between text-slate-500 mb-1">
                <span class="text-xs font-medium">Peminjaman Aktif</span>
                <span class="p-1.5 bg-emerald-50 text-emerald-600 rounded-md"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg></span>
            </div>
            <h2 class="text-2xl font-bold text-[#0F172A] tracking-tight tabular-nums">{{ $jumlahPeminjaman }}</h2>
        </div>
        <p class="text-[11px] text-emerald-600 font-medium mt-3 flex items-center gap-1">Buku yang masih dipinjam</p>
    </div>

    <!-- Pengembalian Buku -->
    <div class="bg-white p-4 rounded-xl border border-[#E2E8F0] shadow-2xs flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between text-slate-500 mb-1">
                <span class="text-xs font-medium">Pengembalian Buku</span>

                <span class="p-1.5 bg-emerald-50 text-emerald-600 rounded-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 14l-4-4m0 0l4-4m-4 4h11a4 4 0 014 4v1">
                        </path>
                    </svg>
                </span>
            </div>

            <h2 class="text-2xl font-bold text-[#0F172A] tracking-tight tabular-nums">
                {{ $jumlahPengembalian }}
            </h2>
        </div>

        <p class="text-[11px] text-emerald-600 font-medium mt-3 flex items-center gap-1">
            Total buku yang sudah dikembalikan
        </p>
    </div>

    <!-- Total Transaksi -->
    <div class="bg-white p-4 rounded-xl border border-[#E2E8F0] shadow-2xs flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between text-slate-500 mb-1">
                <span class="text-xs font-medium">Total Transaksi</span>

                <span class="p-1.5 bg-indigo-50 text-indigo-600 rounded-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l4.414 4.414A1 1 0 0118 8.414V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </span>
            </div>

            <h2 class="text-2xl font-bold text-[#0F172A] tracking-tight tabular-nums">
                {{ $totalTransaksi }}
            </h2>
        </div>

        <p class="text-[11px] text-indigo-600 font-medium mt-3 flex items-center gap-1">
            Seluruh transaksi peminjaman
        </p>
    </div>
</div>

<!-- BAGIAN BAWAH: TABEL PEMINJAMAN TERBARU & AKTIVITAS TERBARU -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Peminjaman Terbaru (Lebar 2 Kolom) -->
    <div class="lg:col-span-2 bg-white rounded-xl border border-[#E2E8F0] shadow-2xs p-5 flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-bold text-[#0F172A] flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-700"></span> Peminjaman Terbaru
                    </h3>
                    <p class="text-[11px] text-slate-500">Transaksi sirkulasi mahasiswa dan staf akademik real-time</p>
                </div>
                <div class="flex items-center gap-2">
                    <input type="text" placeholder="Filter transaksi..." class="bg-slate-50 border border-slate-200 rounded px-2.5 py-1 text-xs text-slate-700">
                    <a href="#" class="text-xs font-medium text-blue-700 hover:underline">Semua →</a>
                </div>
            </div>

            <!-- Tabel Transaksi -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-[#0F172A]">
                    <thead class="bg-slate-50 border-b border-slate-200 text-[10px] text-slate-500 uppercase tracking-wider font-semibold">
                        <tr>
                            <th class="px-3 py-2.5">ID Transaksi</th>
                            <th class="px-3 py-2.5">Peminjam</th>
                            <th class="px-3 py-2.5">Judul Buku</th>
                            <th class="px-3 py-2.5">Tgl Pinjam</th>
                            <th class="px-3 py-2.5">Tgl Kembali</th>
                            <th class="px-3 py-2.5">Status</th>
                        </tr>
                    </thead>
                    <tbody id="tabel-peminjaman" class="divide-y divide-slate-100">
                        <tr>
                            <td colspan="6" class="px-3 py-6 text-center text-slate-500">
                                Memuat data...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">

            <span id="info-peminjaman"></span>

            <div class="flex items-center gap-1">
                <button type="button" id="peminjaman-sebelumnya">
                    Sebelumnya
                </button>

                <span id="peminjaman-halaman">
                    1 / 1
                </span>

                <button type="button" id="peminjaman-selanjutnya">
                    Selanjutnya
                </button>
            </div>
        </div>
    </div>

    <!-- Aktivitas Terbaru (Lebar 1 Kolom) -->
    <div class="bg-white rounded-xl border border-[#E2E8F0] shadow-2xs p-5 flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-[#0F172A] flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-700"></span> Aktivitas Terbaru
                </h3>
            </div>

            <!-- Timeline Aktivitas -->
            <div class="space-y-4 relative text-xs">
                
                @foreach ($peminjamanTerbaru as $peminjaman)
                    <div class="flex items-start gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-library preview-icon"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M7 7v10"/><path d="M11 7v10"/><path d="m15 7 2 10"/></svg>
                        <div>
                            <p class="text-sm font-semibold text-slate-800">
                                {{ $peminjaman->anggota->nama }}
                            </p>

                            <p class="text-xs text-slate-500">
                                Meminjam buku "{{ $peminjaman->buku->judul }}"
                            </p>

                            <p class="text-[10px] text-slate-400">
                                {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}
                            </p>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</div>
@vite('resources/js/dashboard.js')
@endsection