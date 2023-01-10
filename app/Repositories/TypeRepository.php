<?php

namespace App\Repositories;

use App\Models\Type;

class TypeRepository extends BaseRepository
{
    public function __construct(
        private readonly Type $type
    ) {
        parent::__construct($type);
    }
}
