<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\{Http\Controllers\Controller,
    Http\Requests\Admin\Catalog\CollectionRequest,
    Models\Brand,
    Models\CollectionModel,
    Services\Catalog\CollectionService};
use Exception;
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse};
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function __construct(private readonly CollectionService $service)
    {
    }

    public function index(): View
    {
        return view('admin.modules.catalog.collections.index', get_defined_vars());
    }

    public function create(): View
    {
        return view('admin.modules.catalog.collections.create', get_defined_vars());
    }

    public function store(CollectionRequest $request): RedirectResponse
    {
        $data = $request->validated();
        if (isset($data['image']) && $data['image'] != null) {
            $data['image'] = upload_file($data['image'], 'catalog/collections');
        }
        $this->service->create(data: $data);
        flash(__('admin.created_successfully', ['module' => __('admin.collection')]))->success();
        return redirect()->route(route: 'admin.collections.index');
    }

    public function edit(CollectionModel $collection): View
    {
        return view('admin.modules.catalog.collections.edit', get_defined_vars());
    }

    public function update(CollectionRequest $request, CollectionModel $collection): RedirectResponse
    {
        $data = $request->validated();
        if (isset($data['image']) && $data['image'] != null) {
            $data['image'] = upload_file($data['image'], 'catalog/collections', $collection->image);
        }
        $this->service->update(data: $data, id: $collection->id);
        flash(__('admin.updated_successfully', ['module' => __('admin.collection')]))->success();
        return redirect()->route(route: 'admin.collections.index');
    }

    public function destroy(CollectionModel $collection): RedirectResponse
    {
        $this->service->delete(id: $collection->id);
        flash(__('admin.deleted_successfully', ['module' => __('admin.collection')]))->success();
        return back();
    }

    public function list(Request $request): JsonResponse
    {
        return $this->service->list();
    }
}
