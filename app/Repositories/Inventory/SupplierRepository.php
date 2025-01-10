<?php

namespace App\Repositories\Inventory;

use App\{Models\Supplier, Repositories\BaseRepository};

class SupplierRepository extends BaseRepository
{
    public function __construct(Supplier $model)
    {
        parent::__construct($model);
    }
}
