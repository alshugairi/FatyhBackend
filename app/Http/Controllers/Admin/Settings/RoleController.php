<?php

namespace App\Http\Controllers\Admin\Settings;

use App\{Http\Controllers\Controller,
    Http\Requests\Admin\Settings\RoleRequest,
    Models\Role,
    Services\RoleService,
    Services\Settings\PermissionService};
use Exception;
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse};
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * @param RoleService $service
     * @param PermissionService $permissionService
     */
    public function __construct(private readonly RoleService $service,
                                private readonly PermissionService $permissionService)
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('admin.modules.settings.roles.index', get_defined_vars());
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $groupedPermissions = $this->permissionService->groupedPermissions();
        return view('admin.modules.settings.roles.create', get_defined_vars());
    }

    /**
     * @param RoleRequest $request
     * @return RedirectResponse
     */
    public function store(RoleRequest $request): RedirectResponse
    {
        $this->service->create(data: $request->validated());
        flash(__('admin.role').' '.__('admin.created_successfully'))->success();
        return redirect()->route(route: 'admin.roles.index');
    }

    /**
     * @param Role $role
     * @return View
     */
    public function edit(Role $role): View
    {
        $groupedPermissions = $this->permissionService->groupedPermissions();
        $groupedPermissions = $this->permissionService->groupedPermissions();
        $rolePermissions = $this->service->getRolePermissionIds($role);
        return view('admin.modules.settings.roles.edit', get_defined_vars());
    }

    /**
     * @param RoleRequest $request
     * @param Role $role
     * @return RedirectResponse
     */
    public function update(RoleRequest $request, Role $role): RedirectResponse
    {
        $this->service->update(data: $request->validated(), id: $role->id);
        flash(__('admin.role').' '.__('admin.updated_successfully'))->success();
        return redirect()->route(route: 'admin.roles.index');
    }

    /**
     * @param Role $role
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Role $role): RedirectResponse
    {
        $this->service->delete(id: $role->id);
        flash(__('admin.role').' '.__('admin.deleted_successfully'))->success();
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
