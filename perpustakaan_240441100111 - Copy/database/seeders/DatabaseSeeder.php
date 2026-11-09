<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.b
     */
    public function run(): void
    {
        $this->call([
            kategoriSeeder::class,
            RolePermissionSeeder::class,
            UserRoleSeeder::class,
            anggotaSeeder::class,
            bukuSeeder::class,
            peminjamanSeeder::class,
        ]);
    }
}
