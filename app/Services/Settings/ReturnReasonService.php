<?php

namespace App\Services\Settings;

use App\Repositories\Settings\ReturnReasonRepository;
use App\Services\BaseService;
use Illuminate\{Http\JsonResponse, Pipeline\Pipeline};
use Yajra\DataTables\DataTables;
use Exception;

class ReturnReasonService extends BaseService
{
    public function __construct(ReturnReasonRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @param array $filters
     * @param array $relations
     * @return JsonResponse
     * @throws Exception
     */
    public function list(array $filters = [], array $relations = [], array $withCount = []): JsonResponse
    {
        $query = $this->repository->getModel()->with($relations);

        return DataTables::of(app(Pipeline::class)->send($query)->through($filters)->thenReturn())
            ->editColumn('name', function ($item){ return $item->name; })
            ->toJson();
    }
}
