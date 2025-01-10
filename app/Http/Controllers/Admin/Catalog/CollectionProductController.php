<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\{Http\Controllers\Controller,
    Http\Requests\Admin\Catalog\CollectionProductRequest,
    Http\Requests\Admin\Catalog\CollectionRequest,
    Models\Brand,
    Models\CollectionModel,
    Models\Product,
    Pipelines\Catalog\CollectionProductFilterPipeline,
    Services\Catalog\CollectionProductService,
    Services\Catalog\CollectionService,
    Utils\HttpFoundation\Response};
use Exception;
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse};
use Illuminate\Http\Request;

class CollectionProductController extends Controller
{
    public function __construct(private readonly CollectionProductService $service)
    {
    }

    public function index(CollectionModel $collection): View
    {
        return view('admin.modules.catalog.collections.products', get_defined_vars());
    }

    public function store(CollectionProductRequest $request, CollectionModel $collection): Response
    {
        $this->service->create(array_merge($request->validated(), ['collection_id' => $collection->id]));

        return Response::response(
            message: __('admin.success_process'),
        );
    }

    public function list(Request $request, CollectionModel $collection): JsonResponse
    {
        $request->merge(['collection_id' => $collection->id]);
        return $this->service->list(filters: [
            new CollectionProductFilterPipeline(request: $request)
        ], relations: ['product']);
    }

    public function destroy(CollectionModel $collection, Product $product): Response
    {
        $this->service->deleteProductFromCollection(collectionId: $collection->id, productId: $product->id);
        return Response::response(
            message: __('admin.deleted_successfully', ['module' => __('admin.product')])
        );
    }
}
