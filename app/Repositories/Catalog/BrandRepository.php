<?php

namespace App\Repositories\Catalog;

use App\{Models\Brand, Repositories\BaseRepository};

class BrandRepository extends BaseRepository
{
    public function __construct(Brand $model)
    {
        parent::__construct($model);
    }
}
