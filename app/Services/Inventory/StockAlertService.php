<?php

namespace App\Services\Inventory;

use App\{Repositories\Inventory\StockAlertRepository,
    Services\BaseService};

class StockAlertService extends BaseService
{
    public function __construct(StockAlertRepository $repository)
    {
        parent::__construct($repository);
    }
}
