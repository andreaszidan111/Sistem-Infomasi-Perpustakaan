@extends('layouts.admin')

@section('title', 'Manajemen Pengguna Terpadu')

@section('content')
<!-- Top Header & Action Bar -->
<div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-white p-5 rounded-xl border border-[#E2E8F0] shadow-2xs">
    <div>
        <p class="text-[10px] font-semibold tracking-wider text-slate-400 uppercase">MANAJEMEN PENGGUNA TERPADU</p>
        <h1 class="text-xl font-bold text-[#0F172A] mt-0.5">Data Pengguna</h1>
        <p class="text-xs text-[#64748B]">Kelola akun pengguna sistem perpustakaan, otorisasi hak akses, dan status keanggotaan civitas akademika.</p>
    </div>

    <div class="flex items-center gap-2.5 flex-wrap">
        <button type="button" id="btnTambahPengguna" class="inline-flex items-center gap-1.5 bg-[#1E40AF] hover:bg-blue-800 text-white px-3.5 py-1.5 rounded-lg text-xs font-medium transition shadow-2xs">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            + Tambah Pengguna
        </button>
    </div>
</div>
<!-- Form Tambah Pengguna -->
<div id="form-container" class="hidden bg-white rounded-xl border border-[#E2E8F0] shadow-2xs p-5 mt-4">

    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 id="judul-form" class="text-base font-bold text-[#0F172A]">Tambah Pengguna</h2>
            <p class="text-xs text-slate-500 mt-1">
                Masukkan data pengguna yang akan ditambahkan ke sistem.
            </p>
        </div>

        <button type="button" id="tombol-tutup-form"
            class="text-slate-400 hover:text-slate-700 text-lg">
            ×
        </button>
    </div>

    <form id="form-pengguna" class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <!-- Nama -->
        <div>
            <label for="name" class="block text-xs font-medium text-slate-700 mb-1.5">
                Nama Lengkap
            </label>

            <input type="text" id="name" name="name"
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-700"
                placeholder="Masukkan nama lengkap" required>
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-xs font-medium text-slate-700 mb-1.5">
                Email
            </label>

            <input type="email" id="email" name="email"
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-700"
                placeholder="Masukkan email" required>
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-medium text-slate-700 mb-1.5">
                Password
            </label>

            <input type="password" id="password" name="password"
                minlength="8"
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-700"
                placeholder="Minimal 8 karakter">
        </div>

        <!-- Konfirmasi Password -->
        <div>
            <label for="password_confirmation" class="block text-xs font-medium text-slate-700 mb-1.5">
                Konfirmasi Password
            </label>

            <input type="password" id="password_confirmation" name="password_confirmation"
                minlength="8"
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-700"
                placeholder="Ulangi password">
        </div>

        <!-- Role -->
        <div>
            <label for="role" class="block text-xs font-medium text-slate-700 mb-1.5">
                Role Pengguna
            </label>

            <select id="role" name="role"
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-700"
                required>
                <option value="">Pilih Role</option>
                <option value="admin">Admin</option>
                <option value="petugas">Petugas</option>
                <option value="siswa">Siswa</option>
            </select>
        </div>

        <!-- Tombol -->
        <div class="md:col-span-2 flex items-center gap-2 pt-2">
            <button type="submit" id="tombol-submit"
                class="bg-[#1E40AF] hover:bg-blue-800 text-white px-4 py-2 rounded-lg text-xs font-medium">
                Tambah Pengguna
            </button>

            <button type="button" id="tombol-batal"
                class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-lg text-xs font-medium">
                Batal
            </button>
        </div>

    </form>

    <div id="pesan-pengguna" class="mt-4"></div>
</div>
<!-- 4 KARTU METRIK PENGGUNA -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white p-4 rounded-xl border border-[#E2E8F0] shadow-2xs flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between text-slate-500 mb-1">
                <span class="text-xs font-medium">Total Terdaftar</span>
                <span class="p-1.5 bg-blue-50 text-blue-700 rounded-md"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg></span>
            </div>
            <h2 class="text-2xl font-bold text-[#0F172A] tracking-tight tabular-nums">{{ $totalPengguna }}</h2>        
        </div>
        <p class="text-[11px] text-blue-700 font-medium mt-3">Seluruh akun terdaftar</p>
    </div>

    <div class="bg-white p-4 rounded-xl border border-[#E2E8F0] shadow-2xs flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between text-slate-500 mb-1">
                <span class="text-xs font-medium">Anggota Aktif</span>
                <span class="p-1.5 bg-emerald-50 text-emerald-600 rounded-md"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></span>
            </div>
            <h2 class="text-2xl font-bold text-[#0F172A] tracking-tight tabular-nums">{{ $totalSiswa }}</h2>
        </div>
        <p class="text-[11px] text-emerald-600 font-medium mt-3">Pengguna dengan role siswa</p>
    </div>

    <div class="bg-white p-4 rounded-xl border border-[#E2E8F0] shadow-2xs flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between text-slate-500 mb-1">
                <span class="text-xs font-medium">Staf & Pustakawan</span>
                <span class="p-1.5 bg-indigo-50 text-indigo-700 rounded-md"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg></span>
            </div>
            <h2 class="text-2xl font-bold text-[#0F172A] tracking-tight tabular-nums">{{ $totalAdmin + $totalPetugas }}</h2>
        </div>
        <p class="text-[11px] text-indigo-700 font-medium mt-3">Admin: {{ $totalAdmin }} | Petugas: {{ $totalPetugas }}</p>
    </div>

    <div class="bg-white p-4 rounded-xl border border-[#E2E8F0] shadow-2xs flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between text-slate-500 mb-1">
                <span class="text-xs font-medium">Perlu Verifikasi</span>
                <span class="p-1.5 bg-red-50 text-red-600 rounded-md"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg></span>
            </div>
            <h2 class="text-2xl font-bold text-red-600 tracking-tight tabular-nums">{{ $perluVerifikasi }}</h2>
        </div>
        <p class="text-[11px] text-red-600 font-medium mt-3">Akun yang belum verifikasi email</p>
    </div>
</div>

<!-- TABEL UTAMA PENGGUNA -->
<div class="bg-white rounded-xl border border-[#E2E8F0] shadow-2xs p-5 space-y-4">
    <!-- Filter Bar -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
        <form action="{{ route('admin.pengguna') }}" method="GET"
            class="flex flex-wrap items-center gap-3">

            {{-- Pencarian --}}
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama atau email..."
                class="rounded-lg border border-gray-200 px-4 py-2 text-sm"
            >

            {{-- Filter Role --}}
            <select
                name="role"
                onchange="this.form.submit()"
                class="rounded-lg border border-gray-200 px-4 py-2 text-sm"
            >
                <option value="">Semua Role</option>

                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>
                    Admin
                </option>

                <option value="petugas" {{ request('role') == 'petugas' ? 'selected' : '' }}>
                    Petugas
                </option>

                <option value="siswa" {{ request('role') == 'siswa' ? 'selected' : '' }}>
                    Siswa
                </option>
            </select>

            {{-- Filter Status Verifikasi --}}
            <select
                name="status"
                onchange="this.form.submit()"
                class="rounded-lg border border-gray-200 px-4 py-2 text-sm"
            >
                <option value="">Semua Status</option>

                <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>
                    Terverifikasi
                </option>

                <option value="unverified" {{ request('status') == 'unverified' ? 'selected' : '' }}>
                    Belum Terverifikasi
                </option>
            </select>

            <button
                type="submit"
                class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white"
            >
                Cari
            </button>

            <a
                href="{{ route('admin.pengguna') }}"
                class="rounded-lg border border-gray-200 px-4 py-2 text-sm"
            >
                Reset
            </a>

        </form>
        <p class="text-sm text-gray-500">
            Menampilkan {{ $pengguna->count() }}
            dari {{ $pengguna->total() }} akun
        </p>    
    </div>

    <!-- Tabel Data Pengguna -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-[#0F172A]">
            <thead class="bg-slate-50 border-b border-slate-200 text-[10px] text-slate-500 uppercase tracking-wider font-semibold">
                <tr>
                    <th class="px-4 py-3">Pengguna</th>
                    <th class="px-4 py-3">Identitas / NIM</th>
                    <th class="px-4 py-3">Email Resmi</th>
                    <th class="px-4 py-3">Role</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Bergabung</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($pengguna as $user)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3">
                            <p class="font-bold text-slate-900">
                                {{ $user->name }}
                            </p>
                        </td>

                        <td class="px-4 py-3 text-slate-600">
                            {{ $user->id }}
                        </td>

                        <td class="px-4 py-3 text-slate-700">
                            {{ $user->email }}
                        </td>

                        <td class="px-4 py-3">
                            @forelse ($user->roles as $role)
                                <span class="px-2 py-0.5 bg-blue-50 text-blue-700 border border-blue-200 rounded text-[11px] font-semibold">
                                    {{ ucfirst($role->name) }}
                                </span>
                            @empty
                                <span class="text-slate-400">Belum ada role</span>
                            @endforelse
                        </td>

                        <td class="px-4 py-3">
                            @if ($user->email_verified_at)
                                <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 rounded-full text-[10px] font-semibold">
                                    Aktif
                                </span>
                            @else
                                <span class="px-2 py-0.5 bg-yellow-50 text-yellow-700 rounded-full text-[10px] font-semibold">
                                    Belum Verifikasi
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-slate-600">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button
                                type="button"
                                data-id="{{ $user->id }}"
                                class="tombol-edit text-blue-600 hover:text-blue-800"
                            >
                                Edit
                            </button>
                            <button
                                type="button"
                                data-id="{{ $user->id }}"
                                class="tombol-hapus text-red-600 hover:text-red-800 ml-2"
                            >
                                Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-slate-500">
                            Belum ada pengguna.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
        <span>
            Menampilkan {{ $pengguna->firstItem() ?? 0 }}
            sampai {{ $pengguna->lastItem() ?? 0 }}
            dari {{ $pengguna->total() }} pengguna
        </span>

        {{ $pengguna->links() }}
    </div>
</div>
@vite('resources/js/pengguna.js')
@endsection