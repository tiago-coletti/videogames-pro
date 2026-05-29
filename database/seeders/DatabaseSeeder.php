<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            PlataformaSeeder::class,
            CategoriaSeeder::class,
            ProdutoSeeder::class,
            ClienteSeeder::class,
            PedidoSeeder::class,
            PedidoItemSeeder::class,
        ]);
    }
}
