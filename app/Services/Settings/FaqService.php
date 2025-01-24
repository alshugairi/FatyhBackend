<?php

namespace App\Services\Settings;

use App\Helpers\DesignHelper;
use App\Repositories\Settings\FaqRepository;
use App\Services\BaseService;
use Illuminate\{Http\JsonResponse, Pipeline\Pipeline};
use Yajra\DataTables\DataTables;
use Exception;

class FaqService extends BaseService
{
    public function __construct(FaqRepository $repository)
    {
        parent::__construct($repository);
    }

    public function list(array $filters = [], array $relations = [], array $withCount = []): JsonResponse
    {
        $query = $this->repository->getModel()->with($relations);

        return DataTables::of(app(Pipeline::class)->send($query)->through($filters)->thenReturn())
            ->editColumn('question', function ($item){ return $item->question; })
            ->editColumn('category', function ($item){ return $item->category?->name; })
            ->editColumn('is_active', function ($item){ return DesignHelper::renderStatus(status: $item->is_active); })
            ->rawColumns(['is_active'])
            ->toJson();
    }
}
