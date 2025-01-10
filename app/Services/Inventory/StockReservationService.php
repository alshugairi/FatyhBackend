<?php

namespace App\Services\Inventory;

use App\{Repositories\Inventory\StockReservationRepository,
    Services\BaseService};

class StockReservationService extends BaseService
{
    public function __construct(StockReservationRepository $repository)
    {
        parent::__construct($repository);
    }
}
