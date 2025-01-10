<?php

namespace App\Http\Controllers\Admin\Settings;

use App\{Http\Controllers\Controller,
    Http\Requests\Admin\Settings\CurrencyRequest,
    Models\Currency,
    Services\Settings\CurrencyService};
use Exception;
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse, Support\Facades\Cache};
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * @param CurrencyService $service
     */
    public function __construct(private readonly CurrencyService $service)
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('admin.modules.settings.currencies.index', get_defined_vars());
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('admin.modules.settings.currencies.create', get_defined_vars());
    }

    /**
     * @param CurrencyRequest $request
     * @return RedirectResponse
     */
    public function store(CurrencyRequest $request): RedirectResponse
    {
        $this->service->create(data: $request->validated());
        Cache::forget('default_currency');
        flash(__('admin.currency').' '.__('admin.created_successfully'))->success();
        return redirect()->route(route: 'admin.currencies.index');
    }

    /**
     * @param Currency $currency
     * @return View
     */
    public function edit(Currency $currency): View
    {
        return view('admin.modules.settings.currencies.edit', get_defined_vars());
    }

    /**
     * @param CurrencyRequest $request
     * @param Currency $currency
     * @return RedirectResponse
     */
    public function update(CurrencyRequest $request, Currency $currency): RedirectResponse
    {
        $this->service->update(data: $request->validated(), id: $currency->id);
        Cache::forget('default_currency');
        flash(__('admin.currency').' '.__('admin.updated_successfully'))->success();
        return redirect()->route(route: 'admin.currencies.index');
    }

    /**
     * @param Currency $currency
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Currency $currency): RedirectResponse
    {
        $this->service->delete(id: $currency->id);
        flash(__('admin.currency').' '.__('admin.deleted_successfully'))->success();
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
