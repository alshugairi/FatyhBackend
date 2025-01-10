<?php

namespace App\Repositories\Sales;

use App\{Models\Coupon, Repositories\BaseRepository};

class CouponRepository extends BaseRepository
{
    public function __construct(Coupon $model)
    {
        parent::__construct($model);
    }
}
