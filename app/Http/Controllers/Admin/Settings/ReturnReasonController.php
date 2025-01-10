<?php

namespace App\Http\Controllers\Admin\Settings;

use App\{Http\Controllers\Controller,
    Http\Requests\Admin\Settings\ReturnReasonRequest,
    Models\ReturnReason,
    Services\Settings\ReturnReasonService};
use Exception;
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse};
use Illuminate\Http\Request;

class ReturnReasonController extends Controller
{
    /**
     * @param ReturnReasonService $service
     */
    public function __construct(private readonly ReturnReasonService $service)
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('admin.modules.settings.return_reasons.index', get_defined_vars());
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('admin.modules.settings.return_reasons.create', get_defined_vars());
    }

    /**
     * @param ReturnReasonRequest $request
     * @return RedirectResponse
     */
    public function store(ReturnReasonRequest $request): RedirectResponse
    {
        $this->service->create(data: $request->validated());
        flash(__('admin.created_successfully', ['module' => __('admin.return_reason')]))->success();
        return redirect()->route(route: 'admin.return_reasons.index');
    }

    /**
     * @param ReturnReason $returnReason
     * @return View
     */
    public function edit(ReturnReason $returnReason): View
    {
        return view('admin.modules.settings.return_reasons.edit', get_defined_vars());
    }

    /**
     * @param ReturnReasonRequest $request
     * @param ReturnReason $returnReason
     * @return RedirectResponse
     */
    public function update(ReturnReasonRequest $request, ReturnReason $returnReason): RedirectResponse
    {
        $this->service->update(data: $request->validated(), id: $returnReason->id);
        flash(__('admin.updated_successfully', ['module' => __('admin.return_reason')]))->success();
        return redirect()->route(route: 'admin.return_reasons.index');
    }

    /**
     * @param ReturnReason $returnReason
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(ReturnReason $returnReason): RedirectResponse
    {
        $this->service->delete(id: $returnReason->id);
        flash(__('admin.deleted_successfully', ['module' => __('admin.return_reason')]))->success();
        return back();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function list(Request $request): JsonResponse
    {
        return $this->service->list(filters: [], relations: []);
    }
}
