@extends('layouts.app')

@section('title', 'Beranda - Perpustakaan Suki')

@section('content')
    <section class="w-full h-auto flex justify-center items-center gap-4 bg-slate-50 pt-6 px-4">
        <div class="max-w-4xl text-left rounded-xl px-6 py-10 mb-10 font-sans">
            <div class="flex items-center p-2 mb-2 bg-slate-200 rounded-full w-fit">
                <p class="font-semibold text-amber-900 text-xs">PERPUSTAKAAN Suki</p>
            </div>
            <h2 class="text-4xl font-bold text-stone-800 font-[merriweather] mb-3">Temukan Berbagai Buku untuk <span class="text-amber-900 italic">Menambah Wawasan</span></h2>
            <p class="mx-auto text-stone-600 font-semibold">
                Jelajahi koleksi buku kami, mulai dari novel, fiksi sejarah, hingga
                buku pengembangan diri dan teknologi. Semua bisa kamu temukan di sini.
            </p>
            <a href="{{ route('buku.index') }}" class="text-white font-bold flex items-center gap-2 mt-5 p-4 w-fit bg-amber-900 hover:bg-stone-800  rounded-md transition-colors">
                Lihat Daftar Buku
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right preview-icon text-white"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
            <div class="grid grid-cols-3 gap-5 mt-10">
                <div class="bg-white shadow-md rounded-lg p-5 text-left">
                    <div class="flex items-center gap-2 mb-1 text-amber-800">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-open-text preview-icon"><path d="M12 5v16"/><path d="M16 13h2"/><path d="M16 9h2"/><path d="M20.001 19A2 2 0 0022 17V5a2 2 0 00-1.999-2L16 3.002A5 5 0 0012 5a5 5 0 00-4-2H4a2 2 0 00-2 2v12a2 2 0 001.999 2H8a5 5 0 014 2 5 5 0 014-2z"/><path d="M6 13h2"/><path d="M6 9h2"/></svg>
                        <h3 class="font-bold mb-1">Koleksi Lengkap</h3>
                    </div>
                    <p class="text-sm text-stone-600">Berbagai kategori buku tersedia untuk dibaca.</p>
                </div>
                <div class="bg-white shadow-md rounded-lg p-5 text-left">
                    <div class="flex items-center gap-2 mb-1 text-amber-800">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search-check preview-icon"><path d="m8 11 2 2 4-4"/><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                        <h3 class="font-bold mb-1">Detail Informasi</h3>
                    </div>
                    <p class="text-sm text-stone-600">Lihat detail penulis, tahun terbit, dan kategori tiap buku.</p>
                </div>
                <div class="bg-white shadow-md rounded-lg p-5 text-left">
                    <div class="flex items-center gap-2 mb-1 text-amber-800">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap preview-icon"><path d="M15.914 4a1.5 1.5 0 00-2.474-1.561l-9 9A1.5 1.5 0 005.5 14h4.002a.5.5 0 01.471.666L8.086 20a1.5 1.5 0 002.475 1.56l9-9A1.5 1.5 0 0018.5 10h-3.997a.5.5 0 01-.472-.667z"/></svg>
                        <h3 class="font-bold mb-1">Mudah Diakses</h3>
                    </div>
                    <p class="text-sm text-stone-600">Navigasi sederhana untuk menemukan buku favoritmu.</p>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <div class="bg-white rounded-xl shadow-lg p-2">
                <div class="bg-center bg-no-repeat h-96 rounded-lg" style="background-image: url('{{ asset('img/gambar_perpus.jpeg') }}')">
                    <div class="flex flex-col justify-between h-full">
                        <div class="flex items-right bg-white w-fit rounded-full p-2 m-2 gap-2 text-center self-end">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-amber-800 lucide lucide-badge-check preview-icon"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m16 9-5.5 5.5L8 12"/></svg>
                            <p class="font-medium text-xs text-stone-800">KOLEKSI TERVERIFIKASI</p>
                        </div>
                        <div class="bg-slate-100 mx-2 mb-2 p-2 rounded-xl text-left">
                            <p class="font-bold  text-stone-800 font-[merriweather]">"Perpustakaan adalah ruang melahirkan ide-ide, tempat di mana sejarah menjadi hidup."</p>
                            <p class="text-xs text-stone-800 font-semibold">PERPUSTAKAAN</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="w-full h-auto flex flex-col justify-center items-center gap-4 pt-6 px-4">
        <div class="flex w-full justify-start rounded-xl p-4 ">
            <div class="w-full text-left rounded-xl px-6 py-10 mb-4 font-sans">
                <div class="flex items-center p-2 rounded-full w-fit gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-stamp preview-icon text-amber-800"><path d="M14 13V8.5C14 7 15 7 15 5a3 3 0 0 0-6 0c0 2 1 2 1 3.5V13"/><path d="M20 15.5a2.5 2.5 0 0 0-2.5-2.5h-11A2.5 2.5 0 0 0 4 15.5V17a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1z"/><path d="M5 22h14"/></svg>
                    <p class="font-semibold text-amber-900 text-xs">REKOMENDASI</p>
                </div>
                <h2 class="text-3xl font-bold text-stone-800 font-[merriweather] mb-3">Buku Rekomendasi untuk Kamu</h2>
                <div class="flex items-center justify-center">
                    <p class="mx-auto text-stone-600 font-semibold flex-1">
                        Dengan perpustakaan Suki, kamu dapat mengakses koleksi buku kami
                        kapan saja dan di mana saja. Tidak perlu khawatir kehilangan buku fisik,
                        karena semua tersedia secara online.
                    </p>
                    <a href="{{route('buku.index')}}" class="flex flex-1  items-center justify-end text-amber-900 font-semibold gap-2">
                        Lihat Selengkapnya
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right preview-icon"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-4 gap-4 p-4">
            @foreach ($bukuRekomendasi as $buku)
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
        </div>
    </section>
@endsection
