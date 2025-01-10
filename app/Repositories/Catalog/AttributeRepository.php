<?php

namespace App\Repositories\Catalog;

use App\{Models\AttributeModel, Repositories\BaseRepository};

class AttributeRepository extends BaseRepository
{
    public function __construct(AttributeModel $model)
    {
        parent::__construct($model);
    }
}
