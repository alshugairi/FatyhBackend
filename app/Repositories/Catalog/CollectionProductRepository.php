<?php

namespace App\Repositories\Catalog;

use App\{Models\CollectionModel, Models\CollectionProduct, Repositories\BaseRepository};

class CollectionProductRepository extends BaseRepository
{
    public function __construct(CollectionProduct $model)
    {
        parent::__construct($model);
    }
}
