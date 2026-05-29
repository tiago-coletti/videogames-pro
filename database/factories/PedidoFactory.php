<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cliente;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pedido>
 */
class PedidoFactory extends Factory
{
    public function definition(): array
    {
        $subtotal = fake()->randomFloat(2, 50, 1000);
        $frete = fake()->randomElement([0, 15.00, 25.50]);
        $desconto = fake()->randomElement([0, 10.00, 20.00]);
        $total = ($subtotal + $frete) - $desconto;

        return [
            'numero' => 'PED-' . fake()->unique()->regexify('[A-Z0-9]{8}'),
            'status' => fake()->randomElement(['entregue', 'confirmado', 'enviado', 'pendente']),
            'forma_pagamento' => fake()->randomElement(['pix', 'cartao', 'boleto']),
            'subtotal' => $subtotal,
            'frete' => $frete,
            'desconto' => $desconto,
            'total' => $total > 0 ? $total : $subtotal,
            'cliente_id' => Cliente::all()->isEmpty() ? Cliente::factory() : Cliente::all()->random()->id,
        ];
    }
}
