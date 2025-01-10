<?php

namespace App\Services\Settings;

use App\Helpers\DesignHelper;
use App\Repositories\Settings\PostRepository;
use App\Services\BaseService;
use Illuminate\{Database\Eloquent\Model, Http\JsonResponse, Pipeline\Pipeline, Support\Arr, Support\Facades\Storage};
use Yajra\DataTables\DataTables;
use Exception;

class PostService extends BaseService
{
    public function __construct(PostRepository $repository)
    {
        parent::__construct($repository);
    }

    public function getBySlug(string $slug, $relations = []): mixed
    {
        return $this->repository->getModel()->where('slug', $slug)->with($relations)->first();
    }

    public function list(array $filters = [], array $relations = [], array $withCount = []): JsonResponse
    {
        $query = $this->repository->getModel()->with($relations);

        return DataTables::of(app(Pipeline::class)->send($query)->through($filters)->thenReturn())
            ->editColumn('name', function ($item){ return $item->name; })
            ->editColumn('image', function ($item){ return DesignHelper::renderImage($item->image); })
            ->rawColumns(['image'])
            ->toJson();
    }
}
