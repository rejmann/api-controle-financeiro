<?php

namespace Database\Seeders;

use App\Models\Moviment;
use App\Repositories\CategoryRepository;
use Illuminate\Database\Seeder;

class MovimentSeeder extends Seeder
{
    public function __construct(
        private readonly CategoryRepository $categoryRepository
    ){
    }

    public function run(): void
    {
        Moviment::factory()->count(10)->create([
            'categories_id' => $this->categoryRepository->all()->random()->id,
        ]);
    }
}
