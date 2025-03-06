<?php

namespace App\Services;

use App\Repositories\Catalog\ProductRepository;
use App\Repositories\WishlistRepository;

class WishlistService extends BaseService
{
    public function __construct(WishlistRepository $repository,
                                private readonly ProductRepository $productRepository,)
    {
        parent::__construct($repository);
    }

    public function getWishlist($paginate = 24)
    {
        return $this->productRepository->newQuery()
                    ->join('wishlists', 'products.id', '=', 'wishlists.product_id')
                    ->where('user_id', auth()->id())
                    ->select('products.*')
                    ->with('images')
                    ->paginate($paginate);
    }
}
