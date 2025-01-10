<?php

namespace App\Http\Controllers\Frontend;

use App\{Enums\UserType,
    Http\Controllers\Controller,
    Http\Requests\Frontend\ContactRequest,
    Models\CollectionModel,
    Models\Product,
    Models\ProductImage,
    Pipelines\Catalog\BrandFilterPipeline,
    Pipelines\Catalog\ProductFilterPipeline,
    Pipelines\Settings\PostFilterPipeline,
    Pipelines\SortFilterPipeline,
    Services\Catalog\BrandService,
    Services\Catalog\ProductService,
    Services\ContactService,
    Services\Settings\PostService,
    Utils\HttpFoundation\Response};
use Illuminate\{Contracts\View\View, Http\Request, Support\Facades\DB};

class PageController extends Controller
{
    public function __construct(private readonly ProductService $productService,
                                private readonly BrandService $brandService,
                                private readonly PostService $postService,)
    {
    }

    public function index(): View
    {
        $sliders = $this->postService->getAll(filters: [
                        new SortFilterPipeline(sortByColumn: 'id', sortType: 'desc'),
                        new PostFilterPipeline(new Request(['type' => 'slider']))
                    ], relations: [], limit: 10);

        $collections = CollectionModel::with([
                        'collectionProducts' => function ($query) {
                            $query->limit(20);
                        },
                        'collectionProducts.product' => function ($query) {
                            $query->with(['defaultImage'])->withWishlists();
                        }
                    ])->get();

        $newArrivalProducts = $this->productService->getAll(filters: [
                        new SortFilterPipeline(sortByColumn: 'id', sortType: 'desc'),
                        new ProductFilterPipeline(new Request(['arrival_date' => now()->subDays(60)]))
                    ], limit: 24, relations: ['defaultImage'], scopes: [ fn($query) => $query->withWishlists('value') ]);


        return view('frontend.modules.home', get_defined_vars());
    }

    public function page(string $slug): View
    {
        $page = $this->postService->getBySlug(slug: $slug);
        return view('frontend.modules.page', get_defined_vars());
    }

    public function contact(): View
    {
        return view('frontend.modules.contact', get_defined_vars());
    }

    public function sendContact(ContactRequest $request): Response
    {
        app(ContactService::class)->create(data: $request->validated());
        return Response::response(
            message: __(key:'frontend.message_sent_successfully'),
        );
    }
}
