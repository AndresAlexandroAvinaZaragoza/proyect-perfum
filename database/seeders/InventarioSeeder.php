<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Inventario;
use App\Models\Perfume;

class InventarioSeeder extends Seeder
{
    public function run(): void
    {
        $perfumes = Perfume::all();

        foreach ($perfumes as $perfume) {
            Inventario::factory()->create([
                'perfume_id' => $perfume->id
            ]);
        }
    }
}