<?php

namespace App\Http\Controllers\Frontend;

use App\{Http\Controllers\Controller,
    Http\Requests\Frontend\ReviewRequest,
    Models\Product,
    Services\Catalog\ProductService,
    Services\ReviewService};
use Illuminate\{Http\RedirectResponse};

class ReviewController extends Controller
{
    public function __construct(private readonly ReviewService $reviewService,
                                private readonly ProductService $productService)
    {
    }

    public function store(ReviewRequest $request): RedirectResponse
    {
        $this->reviewService->create(data: array_merge($request->validated(), ['user_id' => auth()->id()]));
        $product = $this->productService->find(id: $request->get('product_id'));
        $this->productService->update(data: ['rating' => number_format($product->averageRating(), 1)], id: $request->get('product_id'));
        flash(__('frontend.review_added_successfully'))->success();
        return back();
    }
}
