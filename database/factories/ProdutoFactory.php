<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Produto;
use App\Models\Plataforma;
use App\Models\Categoria;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produto>
 */
class ProdutoFactory extends Factory
{
    public function definition(): array
    {
        $preco = fake()->randomFloat(2, 50, 4500);
        $precoPromocional = fake()->boolean(30) ? $preco * 0.8 : null;

        return [
            'nome' => fake()->words(3, true),
            'descricao' => fake()->paragraph(),
            'preco' => $preco,
            'preco_promocional' => $precoPromocional,
            'estoque' => fake()->numberBetween(0, 50),
            'tipo' => fake()->randomElement(['jogo', 'console', 'acessorio']),
            'classificacao_etaria' => fake()->randomElement(['Livre', '10', '12', '14', '16', '18', null]),
            'desenvolvedora' => fake()->boolean(80) ? fake()->company() : null,
            'distribuidora' => fake()->company(),
            'data_lancamento' => fake()->date(),
            'destaque' => fake()->boolean(),
            'ativo' => true,
            'plataforma_id' => Plataforma::all()->isEmpty() ? Plataforma::factory() : Plataforma::all()->random()->id,
            'categoria_id' => fake()->boolean(80) && !Categoria::all()->isEmpty() ? Categoria::all()->random()->id : null,
        ];
    }
}
