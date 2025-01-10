<?php

namespace App\Repositories\Catalog;

use App\{Models\ProductVariantAttribute, Repositories\BaseRepository};

class ProductVariantAttributeRepository extends BaseRepository
{
    public function __construct(ProductVariantAttribute $model)
    {
        parent::__construct($model);
    }
}
