<?php

namespace App\Repositories\Inventory;

use App\{Models\StockMovement, Repositories\BaseRepository};

class StockMovementRepository extends BaseRepository
{
    public function __construct(StockMovement $model)
    {
        parent::__construct($model);
    }
}
