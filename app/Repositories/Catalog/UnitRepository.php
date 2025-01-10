<?php

namespace App\Repositories\Catalog;

use App\{Models\Unit, Repositories\BaseRepository};

class UnitRepository extends BaseRepository
{
    public function __construct(Unit $model)
    {
        parent::__construct($model);
    }
}
