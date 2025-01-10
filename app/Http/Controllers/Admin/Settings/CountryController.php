<?php

namespace App\Http\Controllers\Admin\Settings;

use App\{Http\Controllers\Controller,
    Http\Requests\Admin\Settings\CountryRequest,
    Models\Country,
    Models\Currency,
    Services\Settings\CountryService};
use Exception;
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse};
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * @param CountryService $service
     */
    public function __construct(private readonly CountryService $service)
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('admin.modules.settings.countries.index', get_defined_vars());
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $currencies = Currency::getAll();
        return view('admin.modules.settings.countries.create', get_defined_vars());
    }

    /**
     * @param CountryRequest $request
     * @return RedirectResponse
     */
    public function store(CountryRequest $request): RedirectResponse
    {
        $this->service->create(data: $request->validated());
        flash(__('admin.country').' '.__('admin.created_successfully'))->success();
        return redirect()->route(route: 'admin.countries.index');
    }

    /**
     * @param Country $country
     * @return View
     */
    public function edit(Country $country): View
    {
        $currencies = Currency::getAll();
        return view('admin.modules.settings.countries.edit', get_defined_vars());
    }

    /**
     * @param CountryRequest $request
     * @param Country $country
     * @return RedirectResponse
     */
    public function update(CountryRequest $request, Country $country): RedirectResponse
    {
        $this->service->update(data: $request->validated(), id: $country->id);
        flash(__('admin.country').' '.__('admin.updated_successfully'))->success();
        return redirect()->route(route: 'admin.countries.index');
    }

    /**
     * @param Country $country
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Country $country): RedirectResponse
    {
        $this->service->delete(id: $country->id);
        flash(__('admin.country').' '.__('admin.deleted_successfully'))->success();
        return back();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function list(Request $request): JsonResponse
    {
        return $this->service->list(filters: [], relations: ['currency']);
    }
}
