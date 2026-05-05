<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Perfume;

class PerfumeSeeder extends Seeder
{
    public function run(): void
    {
        Perfume::factory()->count(1000)->create();
    }
}
