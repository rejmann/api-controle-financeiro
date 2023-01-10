<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository extends BaseRepository
{
    public function __construct(
        private readonly Category $category
    ) {
        parent::__construct($category);
    }
}
