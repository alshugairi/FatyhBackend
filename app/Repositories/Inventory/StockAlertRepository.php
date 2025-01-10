<?php

namespace App\Repositories\Inventory;

use App\{Models\StockAlert, Repositories\BaseRepository};

class StockAlertRepository extends BaseRepository
{
    public function __construct(StockAlert $model)
    {
        parent::__construct($model);
    }
}
