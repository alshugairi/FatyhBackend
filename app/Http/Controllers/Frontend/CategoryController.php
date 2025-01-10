<?php

namespace App\Http\Controllers\Frontend;

use App\{Enums\UserType,
    Http\Controllers\Controller,
    Pipelines\Catalog\ProductFilterPipeline,
    Pipelines\SortFilterPipeline,
    Services\Catalog\CategoryService,
    Services\Catalog\ProductService,
    Utils\HttpFoundation\Response};
use Illuminate\{Contracts\View\View, Http\Request, Support\Facades\DB};

class CategoryController extends Controller
{
    public function __construct(private readonly CategoryService $categoryService,private readonly ProductService $productService)
    {
    }

    public function index($slug): View
    {
        $category = $this->categoryService->getBySlug($slug);
        $products = $this->productService->index(filters: [
            new SortFilterPipeline(sortByColumn: 'id', sortType: 'desc'),
            new ProductFilterPipeline(new Request(['categoryIds' => array_merge($category->getAllDescendantIds(), [$category->id])]))
        ], scopes: [ fn($query) => $query->withWishlists('value') ]);
        return view('frontend.modules.category', compact('category', 'products'));
    }
}
