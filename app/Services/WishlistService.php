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
                    ->with(['images','userWishlist'])
                    ->paginate($paginate);
    }

    public function addToWishlist(int $productId): mixed
    {
        $userId = auth()->id();

        if ($this->repository->newQuery()->where('user_id', $userId)->where('product_id', $productId)->exists()) {
            throw new \Exception(__('share.product_already_exists'));
        }


        return $this->repository->create([
            'user_id'    => $userId,
            'product_id' => $productId,
        ]);
    }

    public function removeFromWishlist(int $productId): mixed
    {
        $userId = auth()->id();

        if (!$this->repository->newQuery()->where('user_id', $userId)->where('product_id', $productId)->exists()) {
            throw new \Exception(__('share.not_found'));
        }

        return $this->repository->newQuery()
            ->where('user_id', $userId)
            ->where('product_id', $productId)
            ->delete();
    }
}
