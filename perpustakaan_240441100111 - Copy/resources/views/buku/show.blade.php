@extends('layouts.app')

@section('title', $buku ? 'Detail Buku: ' . $buku['judul'] : 'Buku Tidak Ditemukan')

@section('content')
@if($buku)
    <div class="max-w-7xl mx-auto px-4 py-6 font-sans">
        <div class="flex items-center justify-between mb-6 text-xs text-stone-500">
            <nav class="flex items-center gap-1.5">
                <a href="{{route('home')}}" class="hover:text-stone-800 transition-colors flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-home"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    <span>Beranda</span>
                </a>
                <span>/</span>
                <a href="{{ route('buku.index') }}" class="hover:text-stone-800 transition-colors">Daftar Buku</a>
                <span>/</span>
                <span class="text-stone-800 font-medium truncate max-w-xs">{{ $buku['judul'] ?? 'Pemrograman Web dengan Laravel' }}</span>
            </nav>
            <a href="{{ route('buku.index') }}" class="inline-flex items-center gap-1 text-[11px] font-bold text-amber-900 hover:text-stone-800 uppercase tracking-wider transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                <span>Kembali ke Daftar Buku</span>
            </a>
        </div>
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-stone-200/80 grid grid-cols-1 md:grid-cols-12 gap-8">
            <div class="md:col-span-4 flex flex-col gap-4">
                <div class="relative rounded-xl overflow-hidden shadow-md bg-stone-100 group">
                    <img src="{{ asset('img/detailBuku.jpeg') }}" alt="{{ $buku['judul'] ?? 'Judul Buku' }}" class="w-full object-cover">
                </div>
            </div>
            <div class="md:col-span-8 flex flex-col justify-between">
                <div>
                    <div class="flex flex-wrap items-center justify-between gap-2 mb-3">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="bg-amber-100/80 text-amber-900 text-[10px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full">
                                {{ $buku['kategori'] ?? 'PEMROGRAMAN' }}
                            </span>
                        </div>
                        <span class="text-[11px] font-medium text-stone-500 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg>
                            Perpustakaan Suki
                        </span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-bold text-stone-900 font-['Merriweather'] mb-1">
                        {{ $buku['judul'] ?? 'Pemrograman Web dengan Laravel' }}
                    </h1>
                    <div class="grid grid-cols-3 gap-4 bg-stone-50 border border-stone-200/60 rounded-xl p-3.5 mb-6">
                        <div>
                            <p class="text-[10px] font-bold text-stone-400 uppercase tracking-wider mb-0.5">PENULIS UTAMA</p>
                            <p class="text-xs font-bold text-stone-800">{{ $buku['penulis'] ?? 'Budi Santoso' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-stone-400 uppercase tracking-wider mb-0.5">TAHUN TERBIT</p>
                            <p class="text-xs font-bold text-stone-800">{{ $buku['tahun'] ?? '2024' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-stone-400 uppercase tracking-wider mb-0.5">KATEGORI</p>
                            <p class="text-xs font-bold text-stone-800">{{$buku['kategori']}}</p>
                        </div>
                    </div>
                    <div class="mb-6">
                        <h2 class="text-sm font-bold text-stone-800 mb-2">Sinopsis</h2>
                        <p class="text-xs text-stone-600 leading-relaxed">
                            {{ $buku['sinopsis']}}
                        </p>
                    </div>
                </div>
                <div class="flex items-center justify-between pt-4 border-t border-stone-100 mt-4">
                    <a href="{{ route('buku.index') }}" class="inline-flex items-center gap-2 bg-stone-100 hover:bg-stone-200 text-stone-800 text-xs font-semibold px-4 py-2.5 rounded-xl transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                        <span>Kembali ke Daftar Buku</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@else

<div class="max-w-7xl mx-auto px-4 py-6 font-sans">
    <div class="flex items-center justify-between mb-6 text-xs text-stone-500">
        <nav class="flex items-center gap-1.5">
            <a href="{{route('home')}}" class="hover:text-stone-800 transition-colors flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-home"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <span>Beranda</span>
            </a>
            <span>/</span>
            <a href="{{ route('buku.index') }}" class="hover:text-stone-800 transition-colors">Daftar Buku</a>
            <span>/</span>
            <span class="text-stone-700 font-medium">Buku Tidak Ditemukan</span>
        </nav>
        <a href="{{ route('buku.index') }}" class="inline-flex items-center gap-1 text-[11px] font-bold text-amber-900 hover:text-stone-800 uppercase tracking-wider transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            <span>Kembali ke Daftar Buku</span>
        </a>
    </div>
    <div class="max-w-4xl mx-auto bg-white rounded-3xl p-8 md:p-12 shadow-sm border border-stone-100/80 text-center relative overflow-hidden">
        <div class="relative w-28 h-28 mx-auto mb-6 flex items-center justify-center">
            <div class="w-full h-full bg-stone-100/80 rounded-full flex items-center justify-center">
                <div class="relative text-amber-900">
                    <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-open-check"><path d="M12 7v14"/><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"/></svg>
                </div>
            </div>
            <div class="absolute bottom-0 right-0 bg-amber-900 text-white p-2 rounded-full shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21 21-4.3-4.3"/><circle cx="11" cy="11" r="8"/></svg>
            </div>
        </div>
        <h1 class="text-3xl md:text-4xl font-bold text-stone-900 font-['Merriweather'] mb-3">
            Buku Tidak Ditemukan
        </h1>
        <p class="text-xs md:text-sm text-stone-500 max-w-xl mx-auto leading-relaxed mb-8">
            Data buku dengan nomor identifikasi <span class="font-mono text-amber-900 font-semibold">#{{ $id ?? '999' }}</span> tidak tersedia dalam repositori Perpustakaan Suki. Silakan periksa kembali tautan Anda atau jelajahi koleksi buku lain yang tersedia dalam katalog praktikum.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3 mb-10">
            <a href="{{ route('buku.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-[#8B4513] hover:bg-stone-800 text-white font-semibold text-xs px-5 py-3 rounded-xl shadow-sm transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg>
                <span>Kembali ke Daftar Buku</span>
            </a>

            <a href="/" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-stone-100 hover:bg-stone-200 text-stone-700 font-semibold text-xs px-5 py-3 rounded-xl transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <span>Menuju Halaman Beranda</span>
            </a>
        </div>
    </div>
</div>
@endif
@endsection