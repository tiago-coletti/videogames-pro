<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Plataforma;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plataforma>
 */
class PlataformaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome' => fake()->unique()->word() . ' ' . fake()->randomElement(['Pro', 'Slim', 'X', 'S', 'Edition']),
            'fabricante' => fake()->randomElement(['Sony', 'Microsoft', 'Nintendo', 'Sega']),
            'ano_lancamento' => fake()->numberBetween(1990, 2026),
            'ativo' => true,
        ];
    }
}
