<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements RepositoryInterface
{
    public function __construct(
        protected Model $model
    ) {
    }

    public function find(int $id): ?Model
    {
        return $this->model->newQuery()->find($id);
    }

    public function findBy(array $criterion, string $operator = null): Collection
    {
        return $this->model->newQuery()->where($criterion, $operator)->get();
    }

    public function findOneBy(array $criterion): ?Model
    {
        return $this->model->newQuery()->where($criterion)->first();
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function create(array $data): Model
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(array $data, int $id): Model
    {
        $record = $this->model->newQuery()->find($id);
        $record->update($data);

        return $record;
    }

    public function delete(int $id): Model
    {
        $record = $this->model->newQuery()->find($id);
        $record->delete();

        return $record;
    }
}
