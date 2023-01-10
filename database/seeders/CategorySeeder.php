<?php

namespace Database\Seeders;

use App\Repositories\CategoryRepository;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function __construct(
        private readonly CategoryRepository $categoryRepository
    ) {
    }

    public function run(): void
    {
        $categories = collect([
            'Alimentação',
            'Saúde',
            'Moradia',
            'Transporte',
            'Educação',
            'Lazer',
            'Imprevistos',
            'Outras'
        ]);

        $categories->each(function (string $categories) {
            $this->categoryRepository->create([
                'name' => $categories
            ]);
        });
    }
}
