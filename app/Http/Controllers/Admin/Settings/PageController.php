<?php

namespace App\Http\Controllers\Admin\Settings;

use App\{Http\Controllers\Controller,
    Http\Requests\Admin\Settings\PageRequest,
    Models\Post,
    Pipelines\Settings\PostFilterPipeline,
    Services\Settings\PostService};
use Exception;
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse};
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * @param PostService $service
     */
    public function __construct(private readonly PostService $service)
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('admin.modules.settings.pages.index', get_defined_vars());
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('admin.modules.settings.pages.create', get_defined_vars());
    }

    /**
     * @param PageRequest $request
     * @return RedirectResponse
     */
    public function store(PageRequest $request): RedirectResponse
    {
        $this->service->create(data: array_merge($request->validated(), ['type' => 'page']));
        flash(__('admin.created_successfully', ['module' => __('admin.page')]))->success();
        return redirect()->route(route: 'admin.pages.index');
    }

    /**
     * @param Post $page
     * @return View
     */
    public function edit(Post $page): View
    {
        return view('admin.modules.settings.pages.edit', get_defined_vars());
    }

    /**
     * @param PageRequest $request
     * @param Post $page
     * @return RedirectResponse
     */
    public function update(PageRequest $request, Post $page): RedirectResponse
    {
        $this->service->update(data: $request->validated(), id: $page->id);
        flash(__('admin.updated_successfully', ['module' => __('admin.page')]))->success();
        return redirect()->route(route: 'admin.pages.index');
    }

    /**
     * @param Post $page
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Post $page): RedirectResponse
    {
        $this->service->delete(id: $page->id);
        flash(__('admin.deleted_successfully', ['module' => __('admin.page')]))->success();
        return back();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function list(Request $request): JsonResponse
    {
        $request->merge(['type' => 'page']);
        return $this->service->list(filters: [
            new PostFilterPipeline(request: $request),
        ]);
    }
}
