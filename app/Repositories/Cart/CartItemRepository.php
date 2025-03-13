<?php

namespace App\Repositories\Cart;

use App\Models\CartItem;
use App\Repositories\BaseRepository;

class CartItemRepository extends BaseRepository
{
    public function __construct(CartItem $model)
    {
        parent::__construct($model);
    }
}
