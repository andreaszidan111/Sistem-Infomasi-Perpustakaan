<?php

namespace Database\Factories;

use App\Models\kategori;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<kategori>
 */
class kategoriFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->randomElement([
                'Fiksi',
                'Non Fiksi',
                'Teknologi',
                'Pendidikan',
                'Sejarah',
            ]),
        ];
    }
}
