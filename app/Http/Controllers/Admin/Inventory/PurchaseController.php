<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\{Http\Controllers\Controller,
    Http\Requests\Admin\Inventory\PurchaseRequest,
    Models\Product,
    Models\Purchase,
    Models\Supplier,
    Services\Inventory\PurchaseService};
use Exception;
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse};
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * @param PurchaseService $service
     */
    public function __construct(private readonly PurchaseService $service)
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('admin.modules.inventory.purchases.index', get_defined_vars());
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $suppliers = Supplier::allSuppliers();
        return view('admin.modules.inventory.purchases.create', get_defined_vars());
    }

    /**
     * @param PurchaseRequest $request
     * @return RedirectResponse
     */
    public function store(PurchaseRequest $request): RedirectResponse
    {
        $data = $request->validated();
        if (isset($data['image'])) {
            $data['image'] = upload_file($data['image'], 'inventory/purchases');
        }
        $this->service->create(data: $data);
        flash(__('admin.created_successfully', ['module' => __('admin.purchase')]))->success();
        return redirect()->route(route: 'admin.purchases.index');
    }

    /**
     * @param Purchase $purchase
     * @return View
     */
    public function edit(Purchase $purchase): View
    {
        $suppliers = Supplier::allSuppliers();
        $purchase->load(['items.product.variants.attributeOptions.attribute', 'items.productVariant']);
        return view('admin.modules.inventory.purchases.edit', get_defined_vars());
    }

    /**
     * @param PurchaseRequest $request
     * @param Purchase $purchase
     * @return RedirectResponse
     */
    public function update(PurchaseRequest $request, Purchase $purchase): RedirectResponse
    {
        $data = $request->validated();
        if (isset($data['image'])) {
            $data['image'] = upload_file($data['image'], 'inventory/purchases', $purchase->image);
        }
        $this->service->update(data: $data, id: $purchase->id);
        flash(__('admin.updated_successfully', ['module' => __('admin.purchase')]))->success();
        return redirect()->route(route: 'admin.purchases.index');
    }

    /**
     * @param Purchase $purchase
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Purchase $purchase): RedirectResponse
    {
        $this->service->delete(id: $purchase->id);
        flash(__('admin.deleted_successfully', ['module' => __('admin.purchase')]))->success();
        return back();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function list(Request $request): JsonResponse
    {
        return $this->service->list(filters: [], relations: ['supplier']);
    }
}
