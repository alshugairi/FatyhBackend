<?php

namespace App\Repositories\Catalog;

use App\{Models\Category, Repositories\BaseRepository};

class CategoryRepository extends BaseRepository
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }
}
