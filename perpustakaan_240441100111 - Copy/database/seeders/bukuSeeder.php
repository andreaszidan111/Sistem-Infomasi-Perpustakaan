<?php

namespace Database\Seeders;

use App\Models\buku;
use Illuminate\Database\Seeder;

class bukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        buku::factory(20)->create();
    }
}
