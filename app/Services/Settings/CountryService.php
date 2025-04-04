<?php

namespace App\Services\Settings;

use App\Repositories\Settings\CountryRepository;
use App\Services\BaseService;
use Illuminate\{Database\Eloquent\Model, Http\JsonResponse, Pipeline\Pipeline, Support\Arr, Support\Facades\Storage};
use Yajra\DataTables\DataTables;
use Exception;

class CountryService extends BaseService
{
    /**
     * @param CountryRepository $repository
     */
    public function __construct(CountryRepository $repository)
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
                        ->editColumn('currency', function ($item){ return $item->currency?->name; })
                        ->toJson();
    }
}
