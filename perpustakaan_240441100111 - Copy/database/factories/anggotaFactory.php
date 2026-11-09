<?php

namespace Database\Factories;

use App\Models\anggota;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<anggota>
 */
class anggotaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'no_telepon' => fake()->numerify('08##########'),
        ];
    }
}
