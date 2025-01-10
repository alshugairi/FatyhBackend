<?php

namespace App\Services\Inventory;

use App\{Repositories\Inventory\PurchaseItemRepository,
    Services\BaseService};

class PurchaseItemService extends BaseService
{
    public function __construct(PurchaseItemRepository $repository)
    {
        parent::__construct($repository);
    }
}
