<?php

namespace App\Repositories;

use App\{Models\Wishlist};

class WishlistRepository extends BaseRepository
{
    public function __construct(Wishlist $model)
    {
        parent::__construct($model);
    }
}
