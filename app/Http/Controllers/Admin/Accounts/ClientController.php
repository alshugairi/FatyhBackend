<?php

namespace App\Http\Controllers\Admin\Accounts;

use App\{Enums\UserType,
    Http\Controllers\Controller,
    Http\Requests\Admin\Accounts\ClientAjaxRequest,
    Http\Requests\Admin\Accounts\ClientRequest,
    Models\User,
    Pipelines\UserFilterPipeline,
    Services\UserService,
    Utils\HttpFoundation\Response};
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse, Support\Str};
use Illuminate\Http\Request;
use Exception;

class ClientController extends Controller
{
    public function __construct(private readonly UserService $service)
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('admin.modules.accounts.clients.index', get_defined_vars());
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('admin.modules.accounts.clients.create', get_defined_vars());
    }

    /**
     * @param ClientRequest $request
     * @return RedirectResponse
     */
    public function store(ClientRequest $request): RedirectResponse
    {
        $this->service->create(data:array_merge($request->validated(), ['type' => UserType::CLIENT->value]));
        flash(__('admin.created_successfully', ['module' => __('admin.client')]))->success();
        return redirect()->route(route: 'admin.clients.index');
    }

    /**
     * @param User $client
     * @return View
     */
    public function edit(User $client): View
    {
        return view('admin.modules.accounts.clients.edit', get_defined_vars());
    }

    /**
     * @param ClientRequest $request
     * @param User $client
     * @return RedirectResponse
     */
    public function update(ClientRequest $request, User $client): RedirectResponse
    {
        $this->service->update(data: $request->validated(), id: $client->id);
        flash(__('admin.updated_successfully', ['module' => __('admin.client')]))->success();
        return redirect()->route(route: 'admin.clients.index');
    }

    /**
     * @param User $client
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(User $client): RedirectResponse
    {
        $this->service->delete(id: $client->id);
        flash(__('admin.deleted_successfully', ['module' => __('admin.client')]))->success();
        return back();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function list(Request $request): JsonResponse
    {
        $request->merge(['type' => UserType::CLIENT->value]);
        return $this->service->list(filters: [
            new UserFilterPipeline(request: $request),
        ]);
    }

    public function select(Request $request): mixed
    {
        $request->merge(['type' => UserType::CLIENT->value]);
        return $this->service->select(filters: [
            new UserFilterPipeline(request: $request),
        ]);
    }

    public function ajaxStore(ClientAjaxRequest $request)
    {
        return Response::response(
            message: __('admin.client_created_success'),
            data: $this->service->create(data:array_merge($request->validated(), ['type' => UserType::CLIENT->value, 'password' => Str::random(12)]))
        );
    }
}
