<?php

namespace App\Repositories\Catalog;

use App\{Models\ProductVariant, Repositories\BaseRepository};

class ProductVariantRepository extends BaseRepository
{
    public function __construct(ProductVariant $model)
    {
        parent::__construct($model);
    }
}
