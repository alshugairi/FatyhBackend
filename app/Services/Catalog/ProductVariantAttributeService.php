<?php

namespace App\Services\Catalog;

use App\Repositories\{Catalog\ProductVariantAttributeRepository};
use App\Services\BaseService;

class ProductVariantAttributeService extends BaseService
{
    public function __construct(ProductVariantAttributeRepository $repository)
    {
        parent::__construct($repository);
    }
}
