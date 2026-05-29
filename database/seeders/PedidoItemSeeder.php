<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PedidoItem;

class PedidoItemSeeder extends Seeder
{
    public function run(): void
    {
        PedidoItem::factory()->count(40)->create();
    }
}
