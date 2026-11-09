@props([
    'judul',
    'penulis',
    'tahun',
    'deskripsi',
    'sinopsis',
])

<div class="bg-white rounded-2xl p-3 shadow-sm border border-slate-100 max-w-sm flex flex-col justify-between">
    <div>
        <div class="relative w-full h-48 rounded-xl overflow-hidden bg-slate-100 mb-3">
            <img src="{{ asset('img/buku.jpeg') }}" alt="{{ $judul }}" class="w-full h-full object-cover">
            @isset($keterangan)
                <div class="absolute top-2 right-2 bg-amber-900 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                    {{$keterangan}}
                </div>
            @endisset
        </div>
        <div class="flex items-center gap-1.5 text-xs text-stone-500 mb-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <span>{{ $penulis }}</span>
            <span>•</span>
            <span>Tahun {{ $tahun }}</span>
        </div>
        <h3 class="text-lg font-bold text-stone-800 font-['Merriweather'] leading-snug mb-1.5">
            {{ $judul }}
        </h3>
        <p class="text-xs text-stone-500 line-clamp-2 leading-relaxed mb-3">
            {{ $deskripsi }}
        </p>
    </div>

    <div class="mt-2.5">
        {{ $slot }}
    </div>
</div>