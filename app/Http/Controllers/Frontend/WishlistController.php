<?php

namespace App\Http\Controllers\Frontend;

use App\{Http\Controllers\Controller,
    Http\Requests\Frontend\WishlistRequest,
    Models\Wishlist,
    Pipelines\Catalog\ProductFilterPipeline,
    Pipelines\SortFilterPipeline,
    Pipelines\WishlistFilterPipeline,
    Services\WishlistService,
    Utils\HttpFoundation\Response};
use Illuminate\{Contracts\View\View, Http\Request};

class WishlistController extends Controller
{
    public function __construct(private readonly WishlistService $wishlistService)
    {
    }

    public function index(): View
    {
        $wishlists = $this->wishlistService->index(filters: [
                        new SortFilterPipeline(sortByColumn: 'id', sortType: 'desc'),
                        new WishlistFilterPipeline(new Request(['user_id' => auth()->id()]))
                    ], relations: ['product']);

        return view('frontend.modules.wishlist', get_defined_vars());
    }

    public function add(WishlistRequest $request)
    {
        Wishlist::firstOrCreate([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id
        ]);

        return Response::response(
            message: __('frontend.added_to_wishlist'),
        );
    }

    public function remove($productId)
    {
        $wishlist = Wishlist::where([
            'user_id' => auth()->id(),
            'product_id' => $productId
        ])->firstOrFail();

        $wishlist->delete();

        return Response::response(
            message: __('frontend.removed_from_wishlist'),
        );
    }
}
