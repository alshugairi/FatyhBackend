<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\{Http\Controllers\Controller,
    Http\Requests\Admin\Catalog\ProductImageRequest,
    Http\Requests\Admin\Catalog\ProductRequest,
    Http\Requests\Admin\Catalog\ProductSeoRequest,
    Http\Requests\Admin\Catalog\ProductVideoRequest,
    Http\Resources\Catalog\ProductResource,
    Models\AttributeModel,
    Models\Brand,
    Models\Category,
    Models\Product,
    Pipelines\Catalog\ProductFilterPipeline,
    Pipelines\SortFilterPipeline,
    Services\Catalog\ProductImageService,
    Services\Catalog\ProductService,
    Services\Catalog\ProductVideoService,
    Utils\HttpFoundation\Response};
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse};
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private readonly ProductService $service,
                                private readonly ProductVideoService $productVideoService)
    {
    }

    public function index(): View
    {
        return view('admin.modules.catalog.products.index', get_defined_vars());
    }

    public function create(): View
    {
        $categories = Category::allCategories();
        $brands = Brand::allBrands();
        return view('admin.modules.catalog.products.create', get_defined_vars());
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data = upload_file($data, 'image', 'catalog/products');
        $this->service->create(data: $data);
        flash(__('admin.created_successfully', ['module' => __('admin.product')]))->success();
        return redirect()->route(route: 'admin.products.index');
    }

    public function edit(Product $product): View
    {
        $categories = Category::allCategories();
        $brands = Brand::allBrands();
        return view('admin.modules.catalog.products.edit', get_defined_vars());
    }

    public function show(Product $product): View
    {
        $attributes = AttributeModel::with(['options' => function($query) {
                $query->orderBy('position');
            }])
            ->orderBy('position')
            ->get();

        return view('admin.modules.catalog.products.show', get_defined_vars());
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();
        $data = upload_file($data, 'image', 'catalog/products', $product->image);
        $this->service->update(data: $data, id: $product->id);
        flash(__('admin.updated_successfully', ['module' => __('admin.product')]))->success();
        return redirect()->route(route: 'admin.products.index');
    }

    public function destroy(Product $product): Response
    {
        $this->service->delete(id: $product->id);
        return Response::response(
            message: __('admin.deleted_successfully', ['module' => __('admin.product')])
        );
    }

    public function list(Request $request): JsonResponse
    {
        return $this->service->list(filters: [
            new ProductFilterPipeline(request: $request)
        ], relations: ['category']);
    }

    public function listJson(Request $request): Response
    {
        return Response::response(
            message: __(key:'share.request_successfully'),
            data: ProductResource::collection($this->service->index(
                    filters: [
                    new SortFilterPipeline(sortByColumn: 'id', sortType: 'desc'),
                        new ProductFilterPipeline(request: $request)
                ], paginate: 30
            ))
        );
    }

    public function select(Request $request): mixed
    {
        return $this->service->select(filters:[
            new ProductFilterPipeline(request: $request)
        ], extraColumns: ['has_variants', 'purchase_price', 'sell_price']);
    }

    public function updateSeo(ProductSeoRequest $request, Product $product): Response
    {
        $this->service->update(data: $request->validated(), id: $product->id);
        return Response::response(
            message: __('admin.success_save')
        );
    }

    public function uploadVideo(ProductVideoRequest $request, Product $product): Response
    {
        $productVideo = $this->productVideoService->create(data: array_merge($request->validated(), ['product_id' => $product->id]));
        return Response::response(
            message: __('admin.success_upload'),
            data: ['id' => $productVideo->id, 'provider' => __('admin.'.$productVideo->provider), 'video_path' => $productVideo->video_path]
        );
    }

    public function export(Request $request): mixed
    {
        $type = $request->get('type', 'excel');
        return $this->service->export($type);
    }
}
