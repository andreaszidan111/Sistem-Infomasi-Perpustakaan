
@extends('layouts.siswa')

@section('title', 'Profil Saya')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-white p-5 rounded-xl border border-[#E2E8F0] shadow-2xs">
        <div>
            <p class="text-[10px] font-semibold tracking-wider text-slate-400 uppercase">PENGATURAN SISWA</p>
            <h1 class="text-xl font-bold text-[#0F172A] mt-0.5">Profil Saya</h1>
            <p class="text-xs text-[#64748B]">Kelola informasi pribadi dan keamanan akun Anda.</p>
        </div>

        <span class="px-3 py-1 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-full text-xs font-semibold">
            Sesi Aktif
        </span>
    </div>

    <!-- Notifikasi -->
    @if (session('success'))
        <div class="p-3 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="p-3 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm">
            <p class="font-semibold mb-1">Terjadi kesalahan:</p>
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Kartu Identitas -->
        <div class="bg-white rounded-xl border border-[#E2E8F0] shadow-2xs p-5 flex flex-col items-center text-center space-y-4">

            <div class="w-24 h-24 rounded-full bg-blue-100 border-4 border-slate-100 flex items-center justify-center text-3xl font-bold text-blue-700">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>

            <div>
                <h3 class="text-base font-bold text-[#0F172A]">
                    {{ $user->name }}
                </h3>

                <p class="text-xs text-slate-500 mt-1">
                    {{ $user->email }}
                </p>

                <div class="flex items-center justify-center gap-1.5 mt-2">
                    <span class="px-2.5 py-0.5 bg-blue-50 text-blue-700 border border-blue-200 rounded-full text-[10px] font-semibold">
                        Siswa
                    </span>
                </div>
            </div>

            <div class="w-full border-t border-slate-100 pt-4 space-y-3 text-left text-xs">

                <div class="flex justify-between gap-3">
                    <span class="text-slate-400">ID Pengguna:</span>
                    <span class="font-mono text-slate-800 font-semibold">{{ $user->id }}</span>
                </div>

                <div class="flex justify-between gap-3">
                    <span class="text-slate-400">ID Anggota:</span>
                    <span class="font-mono text-slate-800 font-semibold">{{ $anggota->id }}</span>
                </div>

                <div class="flex justify-between gap-3">
                    <span class="text-slate-400">Nomor Telepon:</span>
                    <span class="text-slate-800 font-semibold">{{ $anggota->no_telepon ?: '-' }}</span>
                </div>

                <div class="flex justify-between gap-3">
                    <span class="text-slate-400">Bergabung:</span>
                    <span class="text-slate-800">
                        {{ $user->created_at?->format('d-m-Y') ?? '-' }}
                    </span>
                </div>

                <div class="flex justify-between gap-3">
                    <span class="text-slate-400">Verifikasi Email:</span>
                    <span class="{{ $user->email_verified_at ? 'text-emerald-600' : 'text-amber-600' }} font-semibold">
                        {{ $user->email_verified_at ? 'Terverifikasi' : 'Belum diverifikasi' }}
                    </span>
                </div>

            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">

            <!-- Form Informasi Pribadi -->
            <div class="bg-white rounded-xl border border-[#E2E8F0] shadow-2xs p-5 space-y-4">

                <h3 class="text-sm font-bold text-[#0F172A] border-b border-slate-100 pb-3">
                    Informasi Data Pribadi
                </h3>

                <form action="{{ route('siswa.profil.update') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    @csrf
                    @method('PATCH')

                    <div class="sm:col-span-2">
                        <label for="name" class="block font-semibold text-slate-700 mb-1">
                            Nama Lengkap
                        </label>
                        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required maxlength="255" class="w-full bg-slate-50 border border-slate-300 rounded px-3 py-2 text-slate-900">

                        @error('name')
                            <p class="text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="email" class="block font-semibold text-slate-700 mb-1">
                            Email
                        </label>
                        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required maxlength="255" class="w-full bg-slate-50 border border-slate-300 rounded px-3 py-2 text-slate-900">

                        @error('email')
                            <p class="text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="no_telepon" class="block font-semibold text-slate-700 mb-1">
                            Nomor Telepon
                        </label>
                        <input id="no_telepon" name="no_telepon" type="tel" value="{{ old('no_telepon', $anggota->no_telepon) }}" required maxlength="20" placeholder="Masukkan nomor telepon" class="w-full bg-slate-50 border border-slate-300 rounded px-3 py-2 text-slate-900">

                        @error('no_telepon')
                            <p class="text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2 flex justify-end gap-2 pt-2">
                        <a href="{{ route('siswa.profil') }}" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg text-xs font-medium hover:bg-slate-200">
                            Batal
                        </a>

                        <button type="submit"
                                class="px-4 py-2 bg-[#1E40AF] text-white rounded-lg text-xs font-medium hover:bg-blue-800">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Form Keamanan Akun -->
            <div class="bg-white rounded-xl border border-[#E2E8F0] shadow-2xs p-5 space-y-4">

                <h3 class="text-sm font-bold text-[#0F172A] border-b border-slate-100 pb-3">
                    Keamanan Akun & Kata Sandi
                </h3>

                <form action="{{ route('siswa.profil.password') }}" method="POST" class="space-y-3 text-xs">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="current_password" class="block font-semibold text-slate-700 mb-1">
                            Kata Sandi Saat Ini
                        </label>
                        <input id="current_password" name="current_password" type="password" required autocomplete="current-password" placeholder="Masukkan kata sandi lama" class="w-full bg-slate-50 border border-slate-300 rounded px-3 py-2">

                        @error('current_password')
                            <p class="text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <div>
                            <label for="password" class="block font-semibold text-slate-700 mb-1">
                                Kata Sandi Baru
                            </label>
                            <input id="password" name="password" type="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" class="w-full bg-slate-50 border border-slate-300 rounded px-3 py-2">

                            @error('password')
                                <p class="text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block font-semibold text-slate-700 mb-1">
                                Konfirmasi Kata Sandi Baru
                            </label>
                            <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" placeholder="Ulangi kata sandi baru" class="w-full bg-slate-50 border border-slate-300 rounded px-3 py-2">
                        </div>

                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit"
                                class="px-4 py-2 bg-[#1E40AF] text-white rounded-lg text-xs font-medium hover:bg-blue-800">
                            Ubah Password
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
@endsection