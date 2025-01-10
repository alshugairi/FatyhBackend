<?php

namespace App\Repositories\Catalog;

use App\{Models\AttributeOption, Repositories\BaseRepository};

class AttributeOptionRepository extends BaseRepository
{
    public function __construct(AttributeOption $model)
    {
        parent::__construct($model);
    }
}
