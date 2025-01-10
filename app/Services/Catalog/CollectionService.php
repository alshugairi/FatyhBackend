<?php

namespace App\Services\Catalog;

use App\Repositories\Catalog\CollectionRepository;
use App\Services\BaseService;
use Illuminate\{Http\JsonResponse, Pipeline\Pipeline};
use Yajra\DataTables\DataTables;

class CollectionService extends BaseService
{
    public function __construct(CollectionRepository $repository)
    {
        parent::__construct($repository);
    }

    public function list(array $filters = [], array $relations = [], array $withCount = []): JsonResponse
    {
        $query = $this->repository->getModel()->with($relations);

        return DataTables::of(app(Pipeline::class)->send($query)->through($filters)->thenReturn())
            ->editColumn('name', function ($item){ return $item->name; })
            ->toJson();
    }
}
