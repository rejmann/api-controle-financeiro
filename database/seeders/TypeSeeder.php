<?php

namespace Database\Seeders;

use App\Repositories\TypeRepository;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    public function __construct(
        private readonly TypeRepository $typeRepository
    ){
    }

    public function run(): void
    {
        collect(['receitas', 'despesas'])
            ->each(
                fn (string $type) => $this->typeRepository->create(['name' => $type])
            );
    }
}
