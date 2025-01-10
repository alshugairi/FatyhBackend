<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\{Http\Controllers\Controller,
    Http\Requests\Admin\Catalog\UnitRequest,
    Models\Unit,
    Services\Catalog\UnitService};
use Exception;
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse};
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * @param UnitService $service
     */
    public function __construct(private readonly UnitService $service)
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('admin.modules.catalog.units.index', get_defined_vars());
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('admin.modules.catalog.units.create', get_defined_vars());
    }

    /**
     * @param UnitRequest $request
     * @return RedirectResponse
     */
    public function store(UnitRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data = upload_file($data, 'image', 'catalog/units');
        $this->service->create(data: $data);
        flash(__('admin.created_successfully', ['module' => __('admin.unit')]))->success();
        return redirect()->route(route: 'admin.units.index');
    }

    /**
     * @param Unit $unit
     * @return View
     */
    public function edit(Unit $unit): View
    {
        return view('admin.modules.catalog.units.edit', get_defined_vars());
    }

    /**
     * @param UnitRequest $request
     * @param Unit $unit
     * @return RedirectResponse
     */
    public function update(UnitRequest $request, Unit $unit): RedirectResponse
    {
        $data = $request->validated();
        $data = upload_file($data, 'image', 'catalog/units', $unit->image);
        $this->service->update(data: $data, id: $unit->id);
        flash(__('admin.updated_successfully', ['module' => __('admin.unit')]))->success();
        return redirect()->route(route: 'admin.units.index');
    }

    /**
     * @param Unit $unit
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Unit $unit): RedirectResponse
    {
        $this->service->delete(id: $unit->id);
        flash(__('admin.deleted_successfully', ['module' => __('admin.unit')]))->success();
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
