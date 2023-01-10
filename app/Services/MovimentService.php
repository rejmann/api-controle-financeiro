<?php

namespace App\Services;

use App\DTO\MovimentFilterDTO;
use App\Repositories\CategoryRepository;
use App\Repositories\MovimentRepository;
use App\Repositories\TypeRepository;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class MovimentService
{
    public function __construct(
        private readonly MovimentRepository $movimentRepository,
        private readonly TypeRepository $typeRepository,
        private readonly CategoryRepository $categoryRepository
    ) {
    }

    public function search(MovimentFilterDTO $dto): Collection
    {
        return $this->movimentRepository->search($dto);
    }

    public function create(MovimentFilterDTO $dto): array|false
    {
        if ($this->movimentRepository->search($dto)->toArray()) {
            return false;
        }

        $data = [
            'description' => $dto->description(),
            'value' => $dto->value(),
            'date' => $dto->date()->format('Y-m-d'),
            'types_id' => $this->typeRepository->findOneBy(['name' => $dto->type()])->id,
        ];

        if ($dto->category()) {
            $categoryId = $this->categoryRepository->findOneBy(['name' => $dto->category()])->id;
            $data =+ ['categories_id' => $categoryId];
        }

        return $this->movimentRepository->create($data)->toArray();
    }

    public function update(MovimentFilterDTO $dto): Model|false
    {
        if (! $this->movimentRepository->find($dto->id())) {
            return false;
        }

        $data = [
            'description' => $dto->description(),
            'value' => $dto->value(),
            'date' => $dto->date()->format('Y-m-d'),
            'types_id' => $this->typeRepository->findOneBy(['name' => $dto->type()])->id,
        ];

        if ($dto->category()) {
            $categoryId = $this->categoryRepository->findOneBy(['name' => $dto->category()])->id;
            $data =+ ['categories_id' => $categoryId];
        }

        return $this->movimentRepository->update($data, $dto->id());
    }

    public function find(int $id): ?Model
    {
        return $this->movimentRepository->find($id);
    }

    public function delete(int $id): Model
    {
        return $this->movimentRepository->delete($id);
    }

    public function searchByPeriod(int $year, int $month, string $type): Collection
    {
        $startDate = DateTime::createFromFormat('Y-m', "$year-$month")
            ->modify('first day of this month');
        $endDate = DateTime::createFromFormat('Y-m', "$year-$month")
            ->modify('last day of this month')
            ->setTime(23, 59, 59);

        return $this->movimentRepository->findByPeriod($startDate, $endDate, $this->typeId($type));
    }

    public function type(string $type): Model
    {
        return $this->typeRepository->findBy(['name' => $type], 'like')->first();
    }

    public function typeId(string $type): int
    {
        return $this->type($type)->id;
    }
}
