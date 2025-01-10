<?php

namespace App\Http\Controllers\Admin\Accounts;

use App\{Enums\UserType,
    Http\Controllers\Controller,
    Http\Requests\Admin\Accounts\AdminRequest,
    Models\Role,
    Models\User,
    Pipelines\UserFilterPipeline,
    Services\UserService};
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse};
use Illuminate\Http\Request;
use Exception;

class AdminController extends Controller
{
    public function __construct(private readonly UserService $service)
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('admin.modules.accounts.admins.index', get_defined_vars());
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $roles = Role::allRoles();

        return view('admin.modules.accounts.admins.create', get_defined_vars());
    }

    /**
     * @param AdminRequest $request
     * @return RedirectResponse
     */
    public function store(AdminRequest $request): RedirectResponse
    {
        $this->service->create(data:array_merge($request->validated(), ['type' => UserType::ADMIN->value]));
        flash(__('admin.created_successfully', ['module' => __('admin.admin')]))->success();
        return redirect()->route(route: 'admin.admins.index');
    }

    /**
     * @param User $admin
     * @return View
     */
    public function edit(User $admin): View
    {
        $roles = Role::allRoles();
        $currentRole = auth()->user()->getRoleNames()->first();
        return view('admin.modules.accounts.admins.edit', get_defined_vars());
    }

    /**
     * @param AdminRequest $request
     * @param User $admin
     * @return RedirectResponse
     */
    public function update(AdminRequest $request, User $admin): RedirectResponse
    {
        $this->service->update(data: $request->validated(), id: $admin->id);
        flash(__('admin.updated_successfully', ['module' => __('admin.admin')]))->success();
        return redirect()->route(route: 'admin.admins.index');
    }

    /**
     * @param User $admin
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(User $admin): RedirectResponse
    {
        $this->service->delete(id: $admin->id);
        flash(__('admin.deleted_successfully', ['module' => __('admin.admin')]))->success();
        return back();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function list(Request $request): JsonResponse
    {
        $request->merge(['type' => UserType::ADMIN->value]);

        return $this->service->list(filters: [
            new UserFilterPipeline(request: $request),
        ]);
    }
}
