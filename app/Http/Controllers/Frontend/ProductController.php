<?php

namespace App\Http\Controllers\Frontend;

use App\{Enums\UserType,
    Http\Controllers\Controller,
    Http\Requests\Frontend\ReviewRequest,
    Models\CollectionModel,
    Models\Product,
    Pipelines\Catalog\ProductFilterPipeline,
    Pipelines\ReviewFilterPipeline,
    Pipelines\SortFilterPipeline,
    Services\Catalog\CategoryService,
    Services\Catalog\ProductService,
    Services\ReviewService,
    Utils\HttpFoundation\Response};
use Illuminate\{Contracts\View\View, Http\RedirectResponse, Http\Request, Support\Facades\DB};

class ProductController extends Controller
{
    public function __construct(private readonly ProductService $productService,
                                private readonly ReviewService $reviewService,)
    {
    }

    public function index(Request $request): View
    {
        $category = null;

        if ($request->filled('category')) {
            $categoryInput = $request->input('category');
            if (is_numeric($categoryInput)) {
                $category = app(CategoryService::class)->getByID(id: $categoryInput , relations:['children']);
                $request->merge(['category' => array_merge($category->getAllDescendantIds(), [$category->id])]);
            }
        }

        $products = $this->productService->index(filters: [
                        new SortFilterPipeline(sortByColumn: 'id', sortType: 'desc'),
                        new ProductFilterPipeline(request: $request)
                    ],relations: ['defaultImage'], scopes: [ fn($query) => $query->withWishlists('value') ]);

        return view('frontend.modules.products', get_defined_vars());
    }

    public function newArrivals(): View
    {
        $products = $this->productService->index(filters: [
                        new SortFilterPipeline(sortByColumn: 'id', sortType: 'desc'),
                        new ProductFilterPipeline(new Request(['arrival_date' => now()->subDays(90)]))
                    ], relations: ['defaultImage'], scopes: [ fn($query) => $query->withWishlists('value') ]);

        return view('frontend.modules.new_arrivals', compact( 'products'));
    }

    public function featuredProducts(): View
    {
        $products = $this->productService->index(filters: [
                        new SortFilterPipeline(sortByColumn: 'id', sortType: 'desc'),
                        new ProductFilterPipeline(new Request(['is_featured' => 1]))
                    ], relations: ['defaultImage'], scopes: [ fn($query) => $query->withWishlists('value') ]);

        return view('frontend.modules.featured_products', compact( 'products'));
    }

    public function collection(CollectionModel $collection)
    {
        $products = $this->productService->getProductsByCollectionId(collectionId: $collection->id);
        return view('frontend.modules.collection', compact( 'collection','products'));
    }

    public function show(Product $product): View
    {
        $product->load([
            'variants' => function($query) {
                $query->with(['attributeOptions.attribute', 'variantAttributes']);
            }
        ]);

        $relatedProducts = $this->productService->getAll(filters: [
                            new SortFilterPipeline(sortByColumn: 'id', sortType: 'desc'),
                            new ProductFilterPipeline(new Request(['category_id' => $product->category_id]))
                        ],limit: 12, relations: ['defaultImage'], scopes: [ fn($query) => $query->withWishlists('value') ]);

        $reviews = $this->reviewService->index(filters: [
                        new SortFilterPipeline(sortByColumn: 'id', sortType: 'desc'),
                        new ReviewFilterPipeline(new Request(['product_id' => $product->id]))
                    ], relations: ['user']);

        $ratingBreakdown = $this->reviewService->ratingBreakdown(productId: $product->id);
        $totalReviews = array_sum($ratingBreakdown);

        $ratingPercentages = array_map(function ($count) use ($totalReviews) {
            return $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
        }, $ratingBreakdown);

        $attributes = $product->variants
            ->flatMap(fn($variant) => $variant->attributeOptions)
            ->groupBy(fn($option) => $option->attribute->name);


        return view('frontend.modules.product_single', get_defined_vars());
    }
}
