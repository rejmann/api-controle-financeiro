<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    public function run(): void
    {
        collect(['receitas', 'despesas'])
            ->each(
                fn (string $type) => Type::query()->create(['name' => $type])
            );
    }
}
