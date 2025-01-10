<?php

namespace App\Repositories\Inventory;

use App\{Models\Purchase, Repositories\BaseRepository};

class PurchaseRepository extends BaseRepository
{
    public function __construct(Purchase $model)
    {
        parent::__construct($model);
    }
}
