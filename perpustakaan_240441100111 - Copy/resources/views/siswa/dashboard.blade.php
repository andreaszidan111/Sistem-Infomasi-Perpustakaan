
@extends('layouts.siswa')

@section('title', 'Dashboard Siswa')

@section('content')

<!-- HEADER DASHBOARD -->
<div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-white p-5 rounded-xl border border-[#E2E8F0] shadow-2xs">
    <div>
        <p class="text-[10px] font-semibold tracking-wider text-blue-700 uppercase">PORTAL SISWA</p>
        <h1 class="text-xl font-bold text-[#0F172A] mt-1">Dashboard Siswa</h1>
        <p class="text-xs text-slate-500 mt-1">Selamat datang, {{ auth()->user()->name }}. Pantau aktivitas perpustakaan Anda di sini.</p>
    </div>
    <div class="flex items-center gap-2">
        <span class="px-3 py-2 bg-blue-50 text-blue-700 rounded-lg text-xs font-semibold border border-blue-100">Akses Siswa</span>
    </div>
</div>

<!-- STATISTIK PEMINJAMAN SISWA -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

    <div class="bg-white p-5 rounded-xl border border-[#E2E8F0] shadow-2xs">
        <div class="flex items-center justify-between">
            <p class="text-xs font-medium text-slate-500">Total Peminjaman</p>
            <div class="w-9 h-9 flex items-center justify-center bg-blue-50 text-blue-600 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m-6-6h12"></path></svg>
            </div>
        </div>
        <h2 class="text-2xl font-bold text-[#0F172A] mt-3">{{ $totalPeminjaman ?? 0 }}</h2>
        <p class="text-[10px] text-slate-400 mt-1">Seluruh pengajuan Anda</p>
    </div>

    <div class="bg-white p-5 rounded-xl border border-[#E2E8F0] shadow-2xs">
        <div class="flex items-center justify-between">
            <p class="text-xs font-medium text-slate-500">Menunggu Persetujuan</p>
            <div class="w-9 h-9 flex items-center justify-center bg-amber-50 text-amber-600 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
        <h2 class="text-2xl font-bold text-amber-600 mt-3">{{ $peminjamanMenunggu ?? 0 }}</h2>
        <p class="text-[10px] text-slate-400 mt-1">Sedang diproses petugas</p>
    </div>

    <div class="bg-white p-5 rounded-xl border border-[#E2E8F0] shadow-2xs">
        <div class="flex items-center justify-between">
            <p class="text-xs font-medium text-slate-500">Sedang Dipinjam</p>
            <div class="w-9 h-9 flex items-center justify-center bg-emerald-50 text-emerald-600 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h14v14H5z"></path></svg>
            </div>
        </div>
        <h2 class="text-2xl font-bold text-emerald-600 mt-3">{{ $peminjamanDisetujui ?? 0 }}</h2>
        <p class="text-[10px] text-slate-400 mt-1">Peminjaman disetujui</p>
    </div>

    <div class="bg-white p-5 rounded-xl border border-[#E2E8F0] shadow-2xs">
        <div class="flex items-center justify-between">
            <p class="text-xs font-medium text-slate-500">Peminjaman Ditolak</p>
            <div class="w-9 h-9 flex items-center justify-center bg-red-50 text-red-600 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path></svg>
            </div>
        </div>
        <h2 class="text-2xl font-bold text-red-600 mt-3">{{ $peminjamanDitolak ?? 0 }}</h2>
        <p class="text-[10px] text-slate-400 mt-1">Pengajuan tidak disetujui</p>
    </div>

</div>

<!-- AKSES CEPAT -->
<div class="bg-white rounded-xl border border-[#E2E8F0] shadow-2xs p-5">
    <div class="mb-5">
        <h2 class="text-sm font-bold text-[#0F172A]">Akses Cepat</h2>
        <p class="text-xs text-slate-500 mt-1">Pilih layanan perpustakaan yang ingin Anda gunakan.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

        <a href="{{ route('siswa.buku') }}" class="group p-4 rounded-xl border border-[#E2E8F0] hover:border-blue-300 hover:bg-blue-50/50 transition">
            <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center mb-3 group-hover:bg-blue-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"></path></svg>
            </div>
            <h3 class="text-sm font-bold text-slate-800">Katalog Buku</h3>
            <p class="text-xs text-slate-500 mt-1">Cari dan lihat koleksi buku perpustakaan.</p>
        </a>

        <a href="{{ route('siswa.peminjaman') }}" class="group p-4 rounded-xl border border-[#E2E8F0] hover:border-blue-300 hover:bg-blue-50/50 transition">
            <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center mb-3 group-hover:bg-emerald-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            </div>
            <h3 class="text-sm font-bold text-slate-800">Ajukan Peminjaman</h3>
            <p class="text-xs text-slate-500 mt-1">Ajukan peminjaman buku yang ingin dibaca.</p>
        </a>

        <a href="{{ route('siswa.status-peminjaman') }}" class="group p-4 rounded-xl border border-[#E2E8F0] hover:border-blue-300 hover:bg-blue-50/50 transition">
            <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center mb-3 group-hover:bg-amber-100">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rotate-cw-fading-clock preview-icon"><path d="M12 3a9.75 9.75 0 0 1 6.74 2.74"/><path d="M18.74 5.74 21 8"/><path d="M21 8V3"/><path d="M7.5 19.794c-6-3.464-6-12.124 0-15.588"/><path d="M7.5 4.206A9 9 0 0 1 12 3"/><path d="M12 7v5l4 2"/><path d="M14 20.775A9 9 0 0 1 12 21"/><path d="M19 17.656a9 9 0 0 1-1.5 1.456"/><path d="M21 12a9 9 0 0 1-.228 2"/><path d="M21 8h-5"/></svg>
            </div>
            <h3 class="text-sm font-bold text-slate-800">Status Peminjaman</h3>
            <p class="text-xs text-slate-500 mt-1">Periksa status pengajuan peminjaman Anda.</p>
        </a>

        <a href="{{ route('siswa.riwayat') }}" class="group p-4 rounded-xl border border-[#E2E8F0] hover:border-blue-300 hover:bg-blue-50/50 transition">
            <div class="w-10 h-10 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center mb-3 group-hover:bg-purple-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-sm font-bold text-slate-800">Riwayat Peminjaman</h3>
            <p class="text-xs text-slate-500 mt-1">Lihat catatan peminjaman buku sebelumnya.</p>
        </a>

        <a href="{{ route('siswa.profil') }}" class="group p-4 rounded-xl border border-[#E2E8F0] hover:border-blue-300 hover:bg-blue-50/50 transition">
            <div class="w-10 h-10 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center mb-3 group-hover:bg-slate-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            <h3 class="text-sm font-bold text-slate-800">Profil Saya</h3>
            <p class="text-xs text-slate-500 mt-1">Lihat dan perbarui informasi akun Anda.</p>
        </a>

    </div>
</div>

<!-- PEMINJAMAN TERBARU -->
<div class="bg-white rounded-xl border border-[#E2E8F0] shadow-2xs overflow-hidden">
    <div class="p-5 border-b border-[#E2E8F0] flex items-center justify-between">
        <div>
            <h2 class="text-sm font-bold text-[#0F172A]">Peminjaman Terbaru</h2>
            <p class="text-xs text-slate-500 mt-1">Aktivitas peminjaman terakhir Anda.</p>
        </div>
        <a href="{{ route('siswa.riwayat') }}" class="text-xs font-semibold text-blue-700 hover:text-blue-900">Lihat Semua</a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 text-slate-500">
                <tr>
                    <th class="px-5 py-3 font-semibold">Judul Buku</th>
                    <th class="px-5 py-3 font-semibold">Tanggal Pengajuan</th>
                    <th class="px-5 py-3 font-semibold">Tanggal Kembali</th>
                    <th class="px-5 py-3 font-semibold">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse(($peminjamanTerbaru ?? collect()) as $item)
                <tr class="hover:bg-slate-50">
                    <td class="px-5 py-3 font-medium text-slate-800">{{ $item->buku->judul ?? '-' }}</td>
                    <td class="px-5 py-3 text-slate-600">{{ $item->tanggal_pinjam ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') : '-' }}</td>
                    <td class="px-5 py-3 text-slate-600">{{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d/m/Y') : '-' }}</td>
                    <td class="px-5 py-3">
                        @if($item->status === 'menunggu')
                            <span class="px-2 py-1 rounded-md bg-amber-50 text-amber-700 font-semibold">Menunggu</span>
                        @elseif($item->status === 'disetujui')
                            <span class="px-2 py-1 rounded-md bg-emerald-50 text-emerald-700 font-semibold">Disetujui</span>
                        @elseif($item->status === 'ditolak')
                            <span class="px-2 py-1 rounded-md bg-red-50 text-red-700 font-semibold">Ditolak</span>
                        @else
                            <span class="px-2 py-1 rounded-md bg-slate-100 text-slate-600 font-semibold">{{ ucfirst($item->status ?? 'Tidak diketahui') }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-5 py-8 text-center text-slate-400">Belum ada aktivitas peminjaman.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
