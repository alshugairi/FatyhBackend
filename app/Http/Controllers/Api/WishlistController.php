<?php

namespace App\Http\Controllers\Api;

use App\{Http\Controllers\Controller,
    Http\Requests\Api\WishlistRequest,
    Http\Resources\Catalog\ProductResource,
    Services\WishlistService,
    Utils\HttpFoundation\Response};
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function __construct(private readonly WishlistService $wishlistService)
    {
    }

    public function index(): Response
    {
        return Response::response(
            message: __(key:'share.request_successfully'),
            data: ProductResource::collection($this->wishlistService->getWishlist())
        );
    }

    public function addToWishlist(WishlistRequest $request): Response
    {
        $added = $this->wishlistService->addToWishlist($request->product_id);

        return Response::response(
            message: __('share.added_successfully'),
        );
    }

    public function removeFromWishlist(WishlistRequest $request): Response
    {
        $removed = $this->wishlistService->removeFromWishlist($request->product_id);

        return Response::response(
            message: __('share.removed_successfully')
        );
    }
}
