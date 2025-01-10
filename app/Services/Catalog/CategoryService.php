<?php

namespace App\Services\Catalog;

use App\Repositories\Catalog\CategoryRepository;
use App\Services\BaseService;
use Illuminate\{Database\Eloquent\Model, Http\JsonResponse, Pipeline\Pipeline, Support\Arr, Support\Facades\Storage};
use Yajra\DataTables\DataTables;
use Exception;

class CategoryService extends BaseService
{
    public function __construct(CategoryRepository $repository)
    {
        parent::__construct($repository);
    }

    public function getBySlug(string $slug, $relations = []): mixed
    {
        return $this->repository->getModel()->where('slug', $slug)->with($relations)->first();
    }

    public function getByID(int $id, $relations = []): mixed
    {
        return $this->repository->getModel()->where('id', $id)->with($relations)->first();
    }

    public function list(array $filters = [], array $relations = [], array $withCount = []): JsonResponse
    {
        $query = $this->repository->getModel()->with($relations);

        return DataTables::of(app(Pipeline::class)->send($query)->through($filters)->thenReturn())
            ->editColumn('parent', function ($item){ return $item->parent?->name; })
            ->editColumn('name', function ($item){ return $item->name; })
            ->toJson();
    }
}
