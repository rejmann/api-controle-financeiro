<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Moviment;
use Illuminate\Database\Seeder;

class MovimentSeeder extends Seeder
{
    public function run(): void
    {
        Moviment::factory()->count(10)->create([
            'category_id' => Category::all()->random()->id,
        ]);
    }
}
