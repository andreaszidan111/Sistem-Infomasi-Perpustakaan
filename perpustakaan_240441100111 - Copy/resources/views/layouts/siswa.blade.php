
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Siswa') - PERPUSSuKi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/js/dashboard.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-[#0F172A] min-h-screen flex antialiased">

    <aside class="w-64 bg-[#0F172A] text-white flex flex-col fixed inset-y-0 left-0 z-30">

        <div class="h-16 flex items-center px-6 border-b border-slate-800">
            <span class="text-lg font-bold tracking-tight text-white">PERPUS<span class="text-blue-500">SuKi</span></span>
            <span class="ml-2 text-[11px] text-slate-400 font-normal">Perpustakaan Asli Ngawi😹</span>
        </div>

        <div class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
            <p class="px-3 text-[10px] font-semibold uppercase tracking-wider text-slate-400 mb-3">MENU UTAMA</p>

            @can('lihat dashboard siswa')
            <a href="{{ route('siswa.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('siswa.dashboard') ? 'bg-[#1E40AF] text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} text-xs font-medium transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Dashboard
            </a>
            @endcan

            @can('lihat buku')
            <a href="{{ route('siswa.buku') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('siswa.buku*') ? 'bg-[#1E40AF] text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} text-xs font-medium transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                Katalog Buku
            </a>
            @endcan

            @can('ajukan peminjaman')
            <a href="{{ route('siswa.peminjaman') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('siswa.peminjaman*') ? 'bg-[#1E40AF] text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} text-xs font-medium transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Ajukan Peminjaman
            </a>
            @endcan

            @can('lihat status peminjaman sendiri')
            <a href="{{ route('siswa.status-peminjaman') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('siswa.status-peminjaman*') ? 'bg-[#1E40AF] text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} text-xs font-medium transition">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rotate-cw-fading-clock preview-icon"><path d="M12 3a9.75 9.75 0 0 1 6.74 2.74"/><path d="M18.74 5.74 21 8"/><path d="M21 8V3"/><path d="M7.5 19.794c-6-3.464-6-12.124 0-15.588"/><path d="M7.5 4.206A9 9 0 0 1 12 3"/><path d="M12 7v5l4 2"/><path d="M14 20.775A9 9 0 0 1 12 21"/><path d="M19 17.656a9 9 0 0 1-1.5 1.456"/><path d="M21 12a9 9 0 0 1-.228 2"/><path d="M21 8h-5"/></svg>
                Status Peminjaman
            </a>
            @endcan

            @can('lihat riwayat peminjaman sendiri')
            <a href="{{ route('siswa.riwayat') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('siswa.riwayat*') ? 'bg-[#1E40AF] text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} text-xs font-medium transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Riwayat Peminjaman
            </a>
            @endcan

            @can('lihat profil sendiri')
            <a href="{{ route('siswa.profil') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('siswa.profil*') ? 'bg-[#1E40AF] text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} text-xs font-medium transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>                Profil
            </a>
            @endcan
        </div>

        <div class="p-3 border-t border-slate-800 bg-slate-950/70">
            <div class="bg-white/5 p-2.5 rounded-lg border border-slate-800 space-y-2">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="overflow-hidden leading-tight">
                        <p class="text-[11px] font-bold text-white truncate">
                            {{ auth()->user()->name }}
                        </p>
                        <span class="inline-block mt-0.5 px-1.5 py-0.5 text-[9px] font-semibold bg-blue-500/20 text-blue-400 rounded border border-blue-500/30">
                            {{ auth()->user()->getRoleNames()->first() }}
                        </span>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-1.5 bg-red-500/10 hover:bg-red-600 text-red-400 hover:text-white py-1.5 rounded text-[11px] font-medium transition border border-red-500/20">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <div class="flex-1 ml-64 flex flex-col min-h-screen">

        <header class="h-14 bg-white border-b border-[#E2E8F0] px-6 flex items-center justify-between sticky top-0 z-20 shadow-xs">
            <div class="flex items-center gap-2 text-xs text-[#64748B]">
                <span class="flex items-center gap-1.5 text-slate-700 font-medium">
                    <svg class="w-3.5 h-3.5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    / Sistem Informasi Perpustakaan
                </span>
            </div>

            <div class="flex items-center gap-3">
                <div id="live-date" class="text-xs text-slate-600 font-medium"></div>

                <div class="flex items-center gap-2 pl-2 border-l border-slate-200">
                    <a href="{{ route('siswa.profil') }}" aria-label="Profil" title="Profil" class="p-1.5 text-slate-600 hover:bg-slate-100 rounded">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </a>
                </div>
            </div>
        </header>

        <main class="flex-1 p-6 space-y-6">
            @yield('content')
        </main>
    </div>

</body>
</html>