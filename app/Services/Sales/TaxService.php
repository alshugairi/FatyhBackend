<?php

namespace App\Services\Sales;

use App\Repositories\Sales\TaxRepository;
use App\Services\BaseService;
use Illuminate\{Http\JsonResponse, Pipeline\Pipeline};
use Yajra\DataTables\DataTables;

class TaxService extends BaseService
{
    public function __construct(TaxRepository $repository)
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
