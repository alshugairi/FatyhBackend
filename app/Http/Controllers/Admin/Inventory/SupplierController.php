<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\{Http\Controllers\Controller,
    Http\Requests\Admin\Inventory\SupplierRequest,
    Models\Supplier,
    Services\Inventory\SupplierService};
use Exception;
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse};
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * @param SupplierService $service
     */
    public function __construct(private readonly SupplierService $service)
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('admin.modules.inventory.suppliers.index', get_defined_vars());
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('admin.modules.inventory.suppliers.create', get_defined_vars());
    }

    /**
     * @param SupplierRequest $request
     * @return RedirectResponse
     */
    public function store(SupplierRequest $request): RedirectResponse
    {
        $data = $request->validated();
        if (isset($data['image'])) {
            $data['image'] = upload_file($data['image'], 'inventory/suppliers');
        }
        $this->service->create(data: $data);
        flash(__('admin.created_successfully', ['module' => __('admin.supplier')]))->success();
        return redirect()->route(route: 'admin.suppliers.index');
    }

    /**
     * @param Supplier $supplier
     * @return View
     */
    public function edit(Supplier $supplier): View
    {
        return view('admin.modules.inventory.suppliers.edit', get_defined_vars());
    }

    /**
     * @param SupplierRequest $request
     * @param Supplier $supplier
     * @return RedirectResponse
     */
    public function update(SupplierRequest $request, Supplier $supplier): RedirectResponse
    {
        $data = $request->validated();
        if (isset($data['image'])) {
            $data['image'] = upload_file($data['image'], 'inventory/suppliers', $supplier->image);
        }
        $this->service->update(data: $data, id: $supplier->id);
        flash(__('admin.updated_successfully', ['module' => __('admin.supplier')]))->success();
        return redirect()->route(route: 'admin.suppliers.index');
    }

    /**
     * @param Supplier $supplier
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Supplier $supplier): RedirectResponse
    {
        $this->service->delete(id: $supplier->id);
        flash(__('admin.deleted_successfully', ['module' => __('admin.supplier')]))->success();
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
