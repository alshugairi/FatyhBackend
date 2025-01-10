<?php

namespace App\Http\Controllers\Admin\Settings;

use App\{Http\Controllers\Controller,
    Http\Requests\Admin\Settings\CityRequest,
    Models\City,
    Models\Country,
    Services\Settings\CityService};
use Exception;
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse};
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * @param CityService $service
     */
    public function __construct(private readonly CityService $service)
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('admin.modules.settings.cities.index', get_defined_vars());
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $countries = Country::getAll();
        return view('admin.modules.settings.cities.create', get_defined_vars());
    }

    /**
     * @param CityRequest $request
     * @return RedirectResponse
     */
    public function store(CityRequest $request): RedirectResponse
    {
        $this->service->create(data: $request->validated());
        flash(__('admin.city').' '.__('admin.created_successfully'))->success();
        return redirect()->route(route: 'admin.cities.index');
    }

    /**
     * @param City $city
     * @return View
     */
    public function edit(City $city): View
    {
        $countries = Country::getAll();
        return view('admin.modules.settings.cities.edit', get_defined_vars());
    }

    /**
     * @param CityRequest $request
     * @param City $city
     * @return RedirectResponse
     */
    public function update(CityRequest $request, City $city): RedirectResponse
    {
        $this->service->update(data: $request->validated(), id: $city->id);
        flash(__('admin.city').' '.__('admin.updated_successfully'))->success();
        return redirect()->route(route: 'admin.cities.index');
    }

    /**
     * @param City $city
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(City $city): RedirectResponse
    {
        $this->service->delete(id: $city->id);
        flash(__('admin.city').' '.__('admin.deleted_successfully'))->success();
        return back();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function list(Request $request): JsonResponse
    {
        return $this->service->list(filters: [], relations: ['country']);
    }
}
