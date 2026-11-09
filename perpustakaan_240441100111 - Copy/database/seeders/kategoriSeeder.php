<?php

namespace Database\Seeders;

use App\Models\kategori;
use Illuminate\Database\Seeder;

class kategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (['Fiksi', 'Non Fiksi', 'Teknologi', 'Pendidikan', 'Sejarah'] as $nama) {
            kategori::firstOrCreate(['nama' => $nama]);
        }
    }
}
