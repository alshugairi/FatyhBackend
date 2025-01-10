<?php

namespace App\Services\Sales;

use App\Repositories\{Sales\OrderItemRepository};
use App\Services\BaseService;

class OrderItemService extends BaseService
{
    public function __construct(OrderItemRepository $repository)
    {
        parent::__construct($repository);
    }
}
