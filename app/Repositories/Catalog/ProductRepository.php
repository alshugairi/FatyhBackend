<?php

namespace App\Repositories\Catalog;

use App\{Models\Product, Repositories\BaseRepository};

class ProductRepository extends BaseRepository
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }
}
