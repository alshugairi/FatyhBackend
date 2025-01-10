<?php

namespace App\Repositories\Catalog;

use App\{Models\ProductImage, Repositories\BaseRepository};

class ProductImageRepository extends BaseRepository
{
    public function __construct(ProductImage $model)
    {
        parent::__construct($model);
    }
}
