<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function find(int $id);

    public function all();

    public function create(array $data);

    public function update(array $data, int $id);

    public function delete(int $id);

    public function findBy(array $criterion);

    public function findOneBy(array $criterion);
}
