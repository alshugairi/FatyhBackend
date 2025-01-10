<?php

namespace App\Services\Inventory;

use App\{Repositories\Inventory\SupplierRepository, Services\BaseService};
use Illuminate\{Http\JsonResponse, Pipeline\Pipeline};
use Yajra\DataTables\DataTables;

class SupplierService extends BaseService
{
    public function __construct(SupplierRepository $repository)
    {
        parent::__construct($repository);
    }

    public function list(array $filters = [], array $relations = [], array $withCount = []): JsonResponse
    {
        $query = $this->repository->getModel()->with($relations);

        return DataTables::of(app(Pipeline::class)->send($query)->through($filters)->thenReturn())
            ->editColumn('name', function ($item){ return $item->name; })
            ->editColumn('company_name', function ($item){ return $item->company_name; })
            ->toJson();
    }
}
