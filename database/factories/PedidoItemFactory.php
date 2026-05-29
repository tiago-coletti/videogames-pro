<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pedido;
use App\Models\Produto;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PedidoItem>
 */
class PedidoItemFactory extends Factory
{
    public function definition(): array
    {
        $quantidade = fake()->numberBetween(1, 3);
        $precoUnitario = fake()->randomFloat(2, 50, 500);

        return [
            'quantidade' => $quantidade,
            'preco_unitario' => $precoUnitario,
            'subtotal' => $quantidade * $precoUnitario,
            'pedido_id' => Pedido::all()->isEmpty() ? Pedido::factory() : Pedido::all()->random()->id,
            'produto_id' => Produto::all()->isEmpty() ? Produto::factory() : Produto::all()->random()->id,
        ];
    }
}
