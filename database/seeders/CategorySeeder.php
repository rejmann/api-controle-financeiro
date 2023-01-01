<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
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
            Category::query()->create([
                'name' => $categories
            ]);
        });
    }
}
