<?php

namespace App\Repositories\Inventory;

use App\{Models\StockReservation, Repositories\BaseRepository};

class StockReservationRepository extends BaseRepository
{
    public function __construct(StockReservation $model)
    {
        parent::__construct($model);
    }
}
