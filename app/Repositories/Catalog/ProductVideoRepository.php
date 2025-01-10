<?php

namespace App\Repositories\Catalog;

use App\{Models\ProductVideo, Repositories\BaseRepository};

class ProductVideoRepository extends BaseRepository
{
    public function __construct(ProductVideo $model)
    {
        parent::__construct($model);
    }
}
