<?php

namespace App\Services\Catalog;

use App\Repositories\{Catalog\ProductImageRepository};
use App\Services\BaseService;

class ProductImageService extends BaseService
{
    public function __construct(ProductImageRepository $repository)
    {
        parent::__construct($repository);
    }

    public function getNextPositionNumberByProductId(int $productId): int
    {
        $maxPosition = $this->repository->getModel()
            ->where('product_id', $productId)
            ->max('position') ?? 0;

        return $maxPosition + 1;
    }
}
