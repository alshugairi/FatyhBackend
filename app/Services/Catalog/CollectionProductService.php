<?php

namespace App\Services\Catalog;

use App\Repositories\Catalog\CollectionProductRepository;
use App\Services\BaseService;
use Illuminate\{Http\JsonResponse, Pipeline\Pipeline};
use Yajra\DataTables\DataTables;

class CollectionProductService extends BaseService
{
    public function __construct(CollectionProductRepository $repository)
    {
        parent::__construct($repository);
    }

    public function list(array $filters = [], array $relations = [], array $withCount = []): JsonResponse
    {
        $query = $this->repository->getModel()->with($relations);

        return DataTables::of(app(Pipeline::class)->send($query)->through($filters)->thenReturn())
            ->editColumn('product', function ($item){ return $item->product?->name; })
            ->toJson();
    }

    public function deleteProductFromCollection(int $collectionId, int $productId): bool
    {
        return $this->repository->getModel()->where('collection_id' , $collectionId)
                    ->where('product_id' , $productId)
                    ->delete();
    }
}
