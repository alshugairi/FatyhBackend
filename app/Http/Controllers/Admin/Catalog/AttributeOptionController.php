<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\{Http\Controllers\Controller,
    Http\Requests\Admin\Catalog\AttributeOptionRequest,
    Models\AttributeModel,
    Models\AttributeOption,
    Pipelines\Catalog\AttributeOptionFilterPipeline,
    Services\Catalog\AttributeOptionService};
use Exception;
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse};
use Illuminate\Http\Request;

class AttributeOptionController extends Controller
{
    /**
     * @param AttributeOptionService $service
     */
    public function __construct(private readonly AttributeOptionService $service)
    {
    }

    /**
     * @param AttributeModel $attribute
     * @return View
     */
    public function index(AttributeModel $attribute): View
    {
        return view('admin.modules.catalog.attributes.options.index', get_defined_vars());
    }

    /**
     * @param AttributeModel $attribute
     * @return View
     */
    public function create(AttributeModel $attribute): View
    {
        return view('admin.modules.catalog.attributes.options.create', get_defined_vars());
    }

    /**
     * @param AttributeOptionRequest $request
     * @param AttributeModel $attribute
     * @return RedirectResponse
     */
    public function store(AttributeOptionRequest $request, AttributeModel $attribute): RedirectResponse
    {
        $this->service->create(data: array_merge($request->validated(), ['attribute_id' => $attribute->id]));
        flash(__('admin.created_successfully', ['module' => __('admin.attribute')]))->success();
        return redirect()->route(route: 'admin.attributes.options.index', parameters: $attribute->id);
    }

    /**
     * @param AttributeModel $attribute
     * @param AttributeOption $option
     * @return View
     */
    public function edit(AttributeModel $attribute, AttributeOption $option): View
    {
        return view('admin.modules.catalog.attributes.options.edit', get_defined_vars());
    }

    /**
     * @param AttributeOptionRequest $request
     * @param AttributeModel $attribute
     * @return RedirectResponse
     */
    public function update(AttributeOptionRequest $request, AttributeModel $attribute): RedirectResponse
    {
        $this->service->update(data: $request->validated(), id: $attribute->id);
        flash(__('admin.updated_successfully', ['module' => __('admin.attribute')]))->success();
        return redirect()->route(route: 'admin.attributes.options.index', parameters: $attribute->id);
    }

    /**
     * @param AttributeModel $attribute
     * @param AttributeOption $option
     * @return RedirectResponse
     */
    public function destroy(AttributeModel $attribute, AttributeOption $option): RedirectResponse
    {
        $this->service->delete(id: $option->id);
        flash(__('admin.attribute').' '.__('admin.deleted_successfully'))->success();
        return back();
    }

    /**
     * @param Request $request
     * @param AttributeModel $attribute
     * @return JsonResponse
     */
    public function list(Request $request, AttributeModel $attribute): JsonResponse
    {
        $request->merge(['attribute_id' => $attribute->id]);
        return $this->service->list(filters: [
            new AttributeOptionFilterPipeline(request: $request)
        ]);
    }
}
