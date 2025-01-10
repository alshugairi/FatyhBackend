<?php

namespace App\Repositories\Inventory;

use App\{Models\PurchaseItem, Repositories\BaseRepository};

class PurchaseItemRepository extends BaseRepository
{
    public function __construct(PurchaseItem $model)
    {
        parent::__construct($model);
    }
}
