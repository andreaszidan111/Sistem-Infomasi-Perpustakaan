<?php

namespace Database\Seeders;

use App\Models\anggota;
use Illuminate\Database\Seeder;

class anggotaSeeder extends Seeder
{
    public function run(): void
    {
        // Pertahankan 10 anggota dummy yang tidak terhubung
        // dengan akun pengguna.
        $jumlahAnggotaDummy = anggota::whereNull('user_id')->count();

        if ($jumlahAnggotaDummy < 10) {
            anggota::factory(10 - $jumlahAnggotaDummy)->create();
        }
    }
}