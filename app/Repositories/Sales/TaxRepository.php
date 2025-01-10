<?php

namespace App\Repositories\Sales;

use App\{Models\Tax, Repositories\BaseRepository};

class TaxRepository extends BaseRepository
{
    public function __construct(Tax $model)
    {
        parent::__construct($model);
    }
}
