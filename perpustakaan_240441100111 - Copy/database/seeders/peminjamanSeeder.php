<?php

namespace Database\Seeders;

use App\Models\peminjaman;
use Illuminate\Database\Seeder;

class peminjamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        peminjaman::factory(20)->create();
    }
}
