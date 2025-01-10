<?php

namespace App\Http\Controllers\Admin\Sales;

use App\{Http\Controllers\Controller, Http\Requests\Admin\Sales\TaxRequest, Models\Tax, Services\Sales\TaxService};
use Exception;
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse};
use Illuminate\Http\Request;

class TaxController extends Controller
{
    /**
     * @param TaxService $service
     */
    public function __construct(private readonly TaxService $service)
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('admin.modules.sales.taxes.index', get_defined_vars());
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('admin.modules.sales.taxes.create', get_defined_vars());
    }

    /**
     * @param TaxRequest $request
     * @return RedirectResponse
     */
    public function store(TaxRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data = upload_file($data, 'image', 'sales/taxes');
        $this->service->create(data: $data);
        flash(__('admin.created_successfully', ['module' => __('admin.tax')]))->success();
        return redirect()->route(route: 'admin.taxes.index');
    }

    /**
     * @param Tax $tax
     * @return View
     */
    public function edit(Tax $tax): View
    {
        return view('admin.modules.sales.taxes.edit', get_defined_vars());
    }

    /**
     * @param TaxRequest $request
     * @param Tax $tax
     * @return RedirectResponse
     */
    public function update(TaxRequest $request, Tax $tax): RedirectResponse
    {
        $data = $request->validated();
        $data = upload_file($data, 'image', 'sales/taxes', $tax->image);
        $this->service->update(data: $data, id: $tax->id);
        flash(__('admin.updated_successfully', ['module' => __('admin.tax')]))->success();
        return redirect()->route(route: 'admin.taxes.index');
    }

    /**
     * @param Tax $tax
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Tax $tax): RedirectResponse
    {
        $this->service->delete(id: $tax->id);
        flash(__('admin.tax').' '.__('admin.deleted_successfully'))->success();
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
