<?php

namespace App\Http\Controllers\Admin\Settings;

use App\{Http\Controllers\Controller,
    Http\Requests\Admin\Settings\PermissionRequest,
    Models\Permission,
    Services\Settings\PermissionService};
use Exception;
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse};
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * @param PermissionService $service
     */
    public function __construct(private readonly PermissionService $service)
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('admin.modules.settings.permissions.index', get_defined_vars());
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('admin.modules.settings.permissions.create', get_defined_vars());
    }

    /**
     * @param PermissionRequest $request
     * @return RedirectResponse
     */
    public function store(PermissionRequest $request): RedirectResponse
    {
        $this->service->create(data: $request->validated());
        flash(__('admin.permission').' '.__('admin.created_successfully'))->success();
        return redirect()->route(route: 'admin.permissions.index');
    }

    /**
     * @param Permission $permission
     * @return View
     */
    public function edit(Permission $permission): View
    {
        return view('admin.modules.settings.permissions.edit', get_defined_vars());
    }

    /**
     * @param PermissionRequest $request
     * @param Permission $permission
     * @return RedirectResponse
     */
    public function update(PermissionRequest $request, Permission $permission): RedirectResponse
    {
        $this->service->update(data: $request->validated(), id: $permission->id);
        flash(__('admin.permission').' '.__('admin.updated_successfully'))->success();
        return redirect()->route(route: 'admin.permissions.index');
    }

    /**
     * @param Permission $permission
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Permission $permission): RedirectResponse
    {
        $this->service->delete(id: $permission->id);
        flash(__('admin.permission').' '.__('admin.deleted_successfully'))->success();
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
