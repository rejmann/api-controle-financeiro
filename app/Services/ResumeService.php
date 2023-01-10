<?php

namespace App\Services;

use App\DTO\MovimentFilterDTO;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Repositories\MovimentRepository;
use Illuminate\Database\Eloquent\Collection;

class ResumeService
{
    public function __construct(
        private readonly CategoryRepository $categoryRepository,
        private readonly MovimentRepository $movimentRepository
    ) {
    }

    public function resume(MovimentFilterDTO $dto): int
    {
        return $this->movimentRepository
            ->search($dto)
            ->sum('value');
    }

    public function resumeSpending(MovimentFilterDTO $dto): array
    {
        return $this->categories()
            ->map(fn (Category $category) => $category->name)
            ->flip()
            ->map(function ($value, $category) use ($dto) {
                $dto->setCategory($category);
                return $this->movimentRepository->search($dto)->sum('value') ?? 0;
            })
            ->toArray();
    }

    private function categories(): Collection
    {
        return $this->categoryRepository->all();
    }
}
