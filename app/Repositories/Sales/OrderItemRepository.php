<?php

namespace App\Repositories\Sales;

use App\{Models\OrderItem, Repositories\BaseRepository};

class OrderItemRepository extends BaseRepository
{
    public function __construct(OrderItem $model)
    {
        parent::__construct($model);
    }
}
