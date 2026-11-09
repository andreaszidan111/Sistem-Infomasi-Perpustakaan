<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\anggota;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            // User Admin
            $admin = User::firstOrCreate(
                ['email' => 'admin@gmail.com'],
                [
                    'name' => 'Admin',
                    'password' => Hash::make('password'),
                ]
            );

            $admin->assignRole('admin');

            // User Petugas
            $petugas = User::firstOrCreate(
                ['email' => 'petugas@gmail.com'],
                [
                    'name' => 'Petugas',
                    'password' => Hash::make('password'),
                ]
            );

            $petugas->assignRole('petugas');

            // User Siswa
            $siswa = User::firstOrCreate(
                ['email' => 'siswa@gmail.com'],
                [
                    'name' => 'Siswa',
                    'password' => Hash::make('password'),
                ]
            );

            $siswa->assignRole('siswa');

            // Cari data anggota berdasarkan user_id atau email.
            // Jika sudah ada, gunakan kembali agar tidak duplikat.
            $anggotaSiswa = anggota::where('user_id', $siswa->id)
                ->first();

            if (!$anggotaSiswa) {
                $anggotaSiswa = anggota::where('email', $siswa->email)
                    ->first();
            }

            if (!$anggotaSiswa) {
                $anggotaSiswa = new anggota();
            }

            $anggotaSiswa->nama = $siswa->name;
            $anggotaSiswa->email = $siswa->email;
            $anggotaSiswa->no_telepon = $anggotaSiswa->no_telepon ?: '-';
            $anggotaSiswa->user_id = $siswa->id;
            $anggotaSiswa->save();
        });
    }
}