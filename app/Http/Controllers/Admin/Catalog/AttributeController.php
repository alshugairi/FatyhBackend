<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\{Http\Controllers\Controller,
    Http\Requests\Admin\Catalog\AttributeRequest,
    Models\AttributeModel,
    Services\Catalog\AttributeService};
use Exception;
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse};
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    /**
     * @param AttributeService $service
     */
    public function __construct(private readonly AttributeService $service)
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('admin.modules.catalog.attributes.index', get_defined_vars());
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('admin.modules.catalog.attributes.create', get_defined_vars());
    }

    /**
     * @param AttributeRequest $request
     * @return RedirectResponse
     */
    public function store(AttributeRequest $request): RedirectResponse
    {
        $this->service->create(data: $request->validated());
        flash(__('admin.created_successfully', ['module' => __('admin.attribute')]))->success();
        return redirect()->route(route: 'admin.attributes.index');
    }

    /**
     * @param AttributeModel $attribute
     * @return View
     */
    public function edit(AttributeModel $attribute): View
    {
        return view('admin.modules.catalog.attributes.edit', get_defined_vars());
    }

    /**
     * @param AttributeRequest $request
     * @param AttributeModel $attribute
     * @return RedirectResponse
     */
    public function update(AttributeRequest $request, AttributeModel $attribute): RedirectResponse
    {
        $this->service->update(data: $request->validated(), id: $attribute->id);
        flash(__('admin.updated_successfully', ['module' => __('admin.attribute')]))->success();
        return redirect()->route(route: 'admin.attributes.index');
    }

    /**
     * @param AttributeModel $attribute
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(AttributeModel $attribute): RedirectResponse
    {
        $this->service->delete(id: $attribute->id);
        flash(__('admin.attribute').' '.__('admin.deleted_successfully'))->success();
        return back();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function list(Request $request): JsonResponse
    {
        return $this->service->list();
    }
}
