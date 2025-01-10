<?php

namespace App\Services\Sales;

use App\Repositories\Sales\CouponRepository;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\{Database\Eloquent\Model, Http\JsonResponse, Pipeline\Pipeline, Support\Arr, Support\Facades\Storage};
use Yajra\DataTables\DataTables;
use Exception;

class CouponService extends BaseService
{
    public function __construct(CouponRepository $repository)
    {
        parent::__construct($repository);
    }

    //

    public function list(array $filters = [], array $relations = [], array $withCount = []): JsonResponse
    {
        $query = $this->repository->getModel()->with($relations);

        return DataTables::of(app(Pipeline::class)->send($query)->through($filters)->thenReturn())
            ->editColumn('name', function ($item){ return $item->name; })
            ->editColumn('start_date', function ($item){ return $item->start_date->format('Y-m-d'); })
            ->editColumn('end_date', function ($item){ return $item->end_date->format('Y-m-d'); })
            ->toJson();
    }
}
