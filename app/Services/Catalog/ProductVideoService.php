<?php

namespace App\Services\Catalog;

use App\Repositories\{Catalog\ProductVideoRepository};
use App\Services\BaseService;

class ProductVideoService extends BaseService
{
    public function __construct(ProductVideoRepository $repository)
    {
        parent::__construct($repository);
    }
}
