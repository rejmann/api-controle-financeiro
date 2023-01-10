<?php

namespace App\Repositories;

use App\DTO\MovimentFilterDTO;
use App\Models\Moviment;
use App\Models\Type;
use Illuminate\Database\Eloquent\Collection;

class MovimentRepository extends BaseRepository
{
    public function __construct(
        private readonly Moviment $moviment
    ) {
        parent::__construct($moviment);
    }

    public function search(MovimentFilterDTO $dto): Collection
    {
        $moviments = $this->moviment
            ->newQuery()
            ->select([
                'moviments.id as id',
                'description',
                'value',
                'date',
                'types.name as type',
                'categories.name as category',
            ])
            ->leftJoin('types', 'types.id', '=', 'moviments.types_id')
            ->leftJoin('categories', 'categories.id', '=', 'moviments.categories_id')
            ->where('types.name', $dto->type());

        if ($dto->id()) {
            $moviments->where('moviments.id', $dto->id());
        }

        if ($dto->description()) {
            $moviments->where('description', 'like', "%{$dto->description()}%");
        }

        if ($dto->category() && Type::EXPENSE === $dto->type()) {
            $moviments
                ->where('categories.name', $dto->category())
                ->whereNotNull('categories.name');
        }

        if ($dto->date()) {
            $moviments->whereBetween('date', [
                $dto->date()->modify('first day of this month')->setTime(00, 00, 00)
                    ->format('Y-m-d'),
                $dto->date()->modify('last day of this month')->setTime(23, 59, 59)
                    ->format('Y-m-t')
            ]);
        }

        return $moviments
            ->orderByDesc('date')
            ->get();
    }
}
