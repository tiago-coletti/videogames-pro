<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plataforma;

class PlataformaSeeder extends Seeder
{
    public function run(): void
    {
        Plataforma::factory()->count(10)->create();
    }
}
