<?php

namespace App\Services\Settings;

use App\Helpers\DesignHelper;
use App\Repositories\Settings\FaqCategoryRepository;
use App\Services\BaseService;
use Illuminate\{Http\JsonResponse, Pipeline\Pipeline};
use Yajra\DataTables\DataTables;
use Exception;

class FaqCategoryService extends BaseService
{
    public function __construct(FaqCategoryRepository $repository)
    {
        parent::__construct($repository);
    }

    public function list(array $filters = [], array $relations = [], array $withCount = []): JsonResponse
    {
        $query = $this->repository->getModel()->with($relations);

        return DataTables::of(app(Pipeline::class)->send($query)->through($filters)->thenReturn())
            ->editColumn('name', function ($item){ return $item->name; })
            ->editColumn('is_active', function ($item){ return DesignHelper::renderStatus(status: $item->is_active); })
            ->rawColumns(['is_active'])
            ->toJson();
    }
}
