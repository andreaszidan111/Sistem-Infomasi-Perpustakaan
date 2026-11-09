@extends('layouts.app')

@section('title', 'Daftar Buku - Perpustakaan Suki')

@section('content')

<div class="w-full text-left rounded-xl px-6 py-8 font-sans">
    <div class="flex items-center justify-between mb-6 text-xs text-stone-500">
        <nav class="flex items-center gap-1.5">
            <a href="{{route('home')}}" class="hover:text-stone-800 transition-colors flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-home"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <span>Beranda</span>
            </a>
            <span>/</span>
            <a href="{{ route('buku.index') }}" class="hover:text-stone-800 transition-colors">Daftar Buku</a>
        </nav>
    </div>
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div class="max-w-3xl">
            <h1 class="text-3xl md:text-4xl font-bold text-stone-800 font-['Merriweather'] tracking-tight mb-2">
                Daftar Buku Perpustakaan
            </h1>
            <p class="text-sm text-stone-600 leading-relaxed">
                Berikut adalah koleksi buku yang tersedia di Perpustakaan Suki Menemani Waktu Luangmu dan Membuka Wawasan Baru.
            </p>
        </div>
        <div class="inline-flex items-center gap-3 bg-stone-200/50 border border-stone-200/80 p-2.5 pr-5 rounded-2xl shrink-0 self-start md:self-end">
            <div class="bg-stone-900 text-white p-2.5 rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-open"><path d="M12 7v14"/><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-stone-500 uppercase tracking-wider leading-none mb-0.5">BUKU TERSEDIA</p>
                <p class="text-base font-extrabold text-stone-800 leading-none">
                    {{ count($daftarBuku ?? []) }} Buku
                </p>
            </div>
        </div>
    </div>
</div>
{{-- nomer 2 --}}
<div class="px-6 pb-6">
    <div class="bg-white rounded-xl border border-stone-200 shadow-sm p-6">
        <h2 
        id="judul-form"
        class="text-lg font-semibold text-stone-800 mb-4">
            Tambah Buku
        </h2>

        <form id="form-buku" class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label for="kategori_id" class="block text-sm font-medium text-stone-700 mb-1">
                    Kategori
                </label>

                <input
                    type="number"
                    id="kategori_id"
                    name="kategori_id"
                    class="w-full rounded-lg border border-stone-300 px-3 py-2"
                    required
                >
            </div>

            <div>
                <label for="judul" class="block text-sm font-medium text-stone-700 mb-1">
                    Judul
                </label>

                <input
                    type="text"
                    id="judul"
                    name="judul"
                    class="w-full rounded-lg border border-stone-300 px-3 py-2"
                    required
                >
            </div>

            <div>
                <label for="penulis" class="block text-sm font-medium text-stone-700 mb-1">
                    Penulis
                </label>

                <input
                    type="text"
                    id="penulis"
                    name="penulis"
                    class="w-full rounded-lg border border-stone-300 px-3 py-2"
                    required
                >
            </div>

            <div>
                <label for="tahun_terbit" class="block text-sm font-medium text-stone-700 mb-1">
                    Tahun Terbit
                </label>

                <input
                    type="number"
                    id="tahun_terbit"
                    name="tahun_terbit"
                    class="w-full rounded-lg border border-stone-300 px-3 py-2"
                    required
                >
            </div>

            <div class="md:col-span-2">
                    <button
                        type="submit"
                        id="tombol-submit"
                        class="rounded-lg bg-stone-800 px-5 py-2.5 text-white"
                    >
                        Tambah Buku
                    </button>
            </div>

        </form>

        <div id="pesan-buku" class="mt-4"></div>
    </div>
</div>

{{-- <div class="grid grid-cols-4 gap-4 p-4 mx-4">
    @foreach ($daftarBuku as $buku)
        <x-kartu-buku
            :judul="$buku['judul']"
            :penulis="$buku['penulis']"
            :tahun="$buku['tahun']"
            :deskripsi="$buku['deskripsi']">    
            <x-slot:keterangan>
                <span> {{ $buku['kategori'] }} </span>
            </x-slot:keterangan>

            <a href="{{ route('buku.show', $buku['id']) }}" class="flex justify-end items-center gap-1 text-xs font-semibold text-amber-900 hover:text-stone-800 transition-colors">
                <span>Lihat Detail</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            </a>
        </x-kartu-buku>
    @endforeach
</div> --}}

{{-- nomer 1 --}}
<div class="px-6 pb-8">
    <div class="overflow-x-auto bg-white rounded-xl border border-stone-200 shadow-sm">
        <table class="w-full text-sm text-left">
            <thead class="bg-stone-100 text-stone-700 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4">No</th>
                    <th class="px-6 py-4">Kategori</th>
                    <th class="px-6 py-4">Judul</th>
                    <th class="px-6 py-4">Penulis</th>
                    <th class="px-6 py-4">Tahun Terbit</th>
                    <th class="px-6 py-4">Aksi</th>
                </tr>
            </thead>

            <tbody id="tabel-buku" class="divide-y divide-stone-200">
                <tr>
                    <td colspan="5" class="px-6 py-6 text-center text-stone-500">
                        Memuat data buku...
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@vite('resources/js/buku.js')
@endsection
