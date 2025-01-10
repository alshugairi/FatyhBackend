<?php

namespace App\Services;

use App\Repositories\WishlistRepository;

class WishlistService extends BaseService
{
    public function __construct(WishlistRepository $repository)
    {
        parent::__construct($repository);
    }
}
