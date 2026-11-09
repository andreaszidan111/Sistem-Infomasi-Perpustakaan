<?php

namespace Database\Factories;

use App\Models\anggota;
use App\Models\buku;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<peminjaman>
 */
class peminjamanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'anggota_id' => Anggota::inRandomOrder()->first()->id,
            'buku_id' => Buku::inRandomOrder()->first()->id,
            'tanggal_pinjam' => fake()->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            'tanggal_kembali' => fake()->boolean(70)
                ? fake()->dateTimeBetween('now', '+1 month')->format('Y-m-d')
                : null,
        ];
    }
}
