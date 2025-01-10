<?php

namespace App\Repositories\Sales;

use App\{Models\Order, Repositories\BaseRepository};

class OrderRepository extends BaseRepository
{
    public function __construct(Order $model)
    {
        parent::__construct($model);
    }
}
