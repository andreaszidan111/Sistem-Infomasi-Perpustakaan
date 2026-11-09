@extends('layouts.siswa')

@section('title', 'Ajukan Peminjaman')

@section('content')

<!-- Header -->
<div class="bg-white p-5 rounded-xl border border-[#E2E8F0] shadow-2xs">
    <p class="text-[10px] font-semibold tracking-wider text-slate-400 uppercase">
        LAYANAN SISWA
    </p>

    <h1 class="text-xl font-bold text-[#0F172A] mt-1">
        Ajukan Peminjaman Buku
    </h1>

    <p class="text-xs text-slate-500 mt-1">
        Pilih buku yang ingin dipinjam dan kirim pengajuan kepada petugas.
    </p>
</div>

<!-- Informasi Alur -->
<div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mt-4">
    <div class="flex gap-3">
        <div class="text-blue-700 text-lg">ⓘ</div>
        <div>
            <p class="text-xs font-semibold text-blue-900">
                Informasi Pengajuan
            </p>
            <p class="text-xs text-blue-800 mt-1">
                Pengajuan yang dikirim akan berstatus Menunggu sampai diperiksa dan disetujui oleh petugas atau admin.
            </p>
        </div>
    </div>
</div>

<!-- Form -->
<div class="bg-white rounded-xl border border-[#E2E8F0] shadow-2xs p-5 mt-4">

    <div class="mb-5">
        <h2 class="text-sm font-bold text-[#0F172A]">
            Formulir Peminjaman
        </h2>
        <p class="text-xs text-slate-500 mt-1">
            Lengkapi informasi pengajuan peminjaman buku.
        </p>
    </div>

    <div id="pesan-peminjaman" class="hidden mb-4 rounded-lg p-3 text-xs"></div>

    <form id="form-peminjaman" class="space-y-5">

        <!-- Identitas Siswa -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                    Nama Siswa
                </label>

                <input
                    type="text"
                    value="{{ auth()->user()->name }}"
                    readonly
                    class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-600"
                >
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                    Email
                </label>

                <input
                    type="email"
                    value="{{ auth()->user()->email }}"
                    readonly
                    class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-600"
                >
            </div>

        </div>

        <div class="border-t border-slate-100"></div>

        <!-- Pilihan Buku -->
        <div>
            <label for="buku_id" class="block text-xs font-semibold text-slate-700 mb-1.5">
                Pilih Buku <span class="text-red-500">*</span>
            </label>

            <select
                id="buku_id"
                name="buku_id"
                required
                class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:outline-none focus:border-blue-700"
            >
                <option value="">Memuat daftar buku...</option>
            </select>

            <p class="text-[11px] text-slate-400 mt-1.5">
                Pilih buku yang ingin kamu pinjam.
            </p>
        </div>

        <!-- Tanggal -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                    Tanggal Pengajuan
                </label>

                <input
                    type="date"
                    value="{{ now()->toDateString() }}"
                    readonly
                    class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-600"
                >

                <p class="text-[11px] text-slate-400 mt-1.5">
                    Diisi otomatis oleh sistem.
                </p>
            </div>

            <div>
                <label for="tanggal_kembali" class="block text-xs font-semibold text-slate-700 mb-1.5">
                    Rencana Tanggal Pengembalian
                </label>

                <input
                    type="date"
                    id="tanggal_kembali"
                    name="tanggal_kembali"
                    min="{{ now()->toDateString() }}"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:outline-none focus:border-blue-700"
                >

                <p class="text-[11px] text-slate-400 mt-1.5">
                    Opsional, dapat disesuaikan dengan ketentuan petugas.
                </p>
            </div>

        </div>

        <!-- Tombol -->
        <div class="flex flex-col sm:flex-row justify-end gap-2 pt-4 border-t border-slate-100">

            <button
                type="reset"
                class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 text-xs font-semibold hover:bg-slate-50"
            >
                Reset
            </button>

            <button
                type="submit"
                id="tombol-ajukan"
                class="px-5 py-2.5 rounded-lg bg-[#1E40AF] hover:bg-blue-800 text-white text-xs font-semibold transition"
            >
                Kirim Pengajuan
            </button>

        </div>

    </form>
</div>

@vite('resources/js/siswa-peminjaman.js')

@endsection