<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\{Http\Controllers\Controller,
    Http\Requests\Admin\Catalog\CategoryRequest,
    Models\Category,
    Pipelines\Catalog\CategoryFilterPipeline,
    Services\Catalog\CategoryService};
use Exception;
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse, Support\Facades\Cache};
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @param CategoryService $service
     */
    public function __construct(private readonly CategoryService $service)
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('admin.modules.catalog.categories.index', get_defined_vars());
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $parentCategories = Category::allCategories();
        return view('admin.modules.catalog.categories.create', get_defined_vars());
    }

    /**
     * @param CategoryRequest $request
     * @return RedirectResponse
     */
    public function store(CategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data = upload_file($data, 'image', 'catalog/categories');
        $this->service->create(data: $data);
        Cache::forget('categories');
        flash(__('admin.created_successfully', ['module' => __('admin.category')]))->success();
        return redirect()->route(route: 'admin.categories.index');
    }

    /**
     * @param Category $category
     * @return View
     */
    public function edit(Category $category): View
    {
        $parentCategories = Category::allCategories();
        return view('admin.modules.catalog.categories.edit', get_defined_vars());
    }

    /**
     * @param CategoryRequest $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $data = $request->validated();
        $data = upload_file($data, 'image', 'catalog/categories', $category->image);
        $this->service->update(data: $data, id: $category->id);
        Cache::forget('categories');
        flash(__('admin.updated_successfully', ['module' => __('admin.category')]))->success();
        return redirect()->route(route: 'admin.categories.index');
    }

    /**
     * @param Category $category
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Category $category): RedirectResponse
    {
        $this->service->delete(id: $category->id);
        flash(__('admin.category').' '.__('admin.deleted_successfully'))->success();
        return back();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function list(Request $request): JsonResponse
    {
        return $this->service->list(filters: [], relations: ['parent']);
    }

    public function select(Request $request): mixed
    {
        return $this->service->select(filters:[
            new CategoryFilterPipeline(request: $request)
        ]);
    }
}
