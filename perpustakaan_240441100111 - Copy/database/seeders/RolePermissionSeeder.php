<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat permission
        $permissions = [
            'lihat dashboard admin',
            'lihat dashboard petugas',
            'lihat dashboard siswa',
            'lihat daftar buku',
            'lihat buku',
            'kelola buku',
            'kelola user',
            'kelola role user',
            'kelola peminjaman',
            'kelola pengembalian',
            'ajukan peminjaman',
            'proses persetujuan peminjaman',
            'catat pengembalian',
            'lihat status peminjaman sendiri',
            'lihat riwayat peminjaman sendiri',
            'lihat peminjaman sendiri',
            'lihat pengembalian sendiri',
            'lihat laporan perpustakaan',
            'lihat profil sendiri',
            'ubah profil sendiri',
        ];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
            ]);
        }

        // Membuat role
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $petugas = Role::firstOrCreate(['name' => 'petugas']);
        $siswa = Role::firstOrCreate(['name' => 'siswa']);

        // Permission Admin
        $admin->syncPermissions([
            'lihat dashboard admin',
            'lihat daftar buku',
            'kelola buku',
            'kelola user',
            'kelola role user',
            'kelola peminjaman',
            'kelola pengembalian',
            'proses persetujuan peminjaman',
            'catat pengembalian',
            'lihat laporan perpustakaan',
            'ajukan peminjaman',
            'lihat status peminjaman sendiri',
            'lihat riwayat peminjaman sendiri',
            'lihat profil sendiri',
            'ubah profil sendiri',
        ]);

        // Permission Petugas
        $petugas->syncPermissions([
            'lihat dashboard petugas',
            'lihat daftar buku',
            'kelola buku',
            'kelola peminjaman',
            'kelola pengembalian',
            'proses persetujuan peminjaman',
            'catat pengembalian',
            'lihat laporan perpustakaan',
            'ajukan peminjaman',
            'lihat status peminjaman sendiri',
            'lihat riwayat peminjaman sendiri',
            'lihat profil sendiri',
            'ubah profil sendiri',
        ]);

        // Permission Siswa
        $siswa->syncPermissions([
            'lihat dashboard siswa',
            'lihat buku',
            'lihat daftar buku',
            'ajukan peminjaman',
            'lihat peminjaman sendiri',
            'lihat pengembalian sendiri',
            'lihat status peminjaman sendiri',
            'lihat riwayat peminjaman sendiri',
            'lihat profil sendiri',
            'ubah profil sendiri',
        ]);
    }
}
