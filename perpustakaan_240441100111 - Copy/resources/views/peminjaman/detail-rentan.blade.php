@extends('layouts.siswa')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-6">

    <div class="bg-white rounded-xl shadow p-6">

        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            Detail Peminjaman
        </h1>

        <div class="space-y-4">

            <div>
                <p class="text-sm text-gray-500">ID Peminjaman</p>
                <p class="font-semibold">{{ $peminjaman->id }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Nama Anggota</p>
                <p class="font-semibold">
                    {{ $peminjaman->anggota->nama ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Buku</p>
                <p class="font-semibold">
                    {{ $peminjaman->buku->judul ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Tanggal Pinjam</p>
                <p class="font-semibold">
                    {{ $peminjaman->tanggal_pinjam }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Tanggal Kembali</p>
                <p class="font-semibold">
                    {{ $peminjaman->tanggal_kembali ?? '-' }}
                </p>
            </div>

        </div>

    </div>

</div>
@endsection