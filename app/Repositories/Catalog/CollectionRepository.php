<?php

namespace App\Repositories\Catalog;

use App\{Models\CollectionModel, Repositories\BaseRepository};

class CollectionRepository extends BaseRepository
{
    public function __construct(CollectionModel $model)
    {
        parent::__construct($model);
    }
}
