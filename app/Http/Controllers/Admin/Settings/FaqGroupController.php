<?php

namespace App\Http\Controllers\Admin\Settings;

use App\{Http\Controllers\Controller,
    Http\Requests\Admin\Settings\FaqGroupRequest,
    Models\FaqGroup,
    Services\Settings\FaqGroupService};
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse};

class FaqGroupController extends Controller
{
    public function __construct(private readonly FaqGroupService $service)
    {
    }

    public function index(): View
    {
        return view('admin.modules.settings.faq_groups.index', get_defined_vars());
    }

    public function create(): View
    {
        return view('admin.modules.settings.faq_groups.create', get_defined_vars());
    }

    public function store(FaqGroupRequest $request): RedirectResponse
    {
        $this->service->create(data: array_merge($request->validated(), ['type' => 'faq_group']));
        flash(__('admin.created_successfully', ['module' => __('admin.faq')]))->success();
        return redirect()->route(route: 'admin.faq_groups.index');
    }

    public function edit(FaqGroup $faqGroup): View
    {
        return view('admin.modules.settings.faq_groups.edit', get_defined_vars());
    }

    public function update(FaqGroupRequest $request, FaqGroup $faqGroup): RedirectResponse
    {
        $this->service->update(data: $request->validated(), id: $faqGroup->id);
        flash(__('admin.updated_successfully', ['module' => __('admin.faq_group')]))->success();
        return redirect()->route(route: 'admin.faq_groups.index');
    }

    public function destroy(FaqGroup $faqGroup): RedirectResponse
    {
        $this->service->delete(id: $faqGroup->id);
        flash(__('admin.deleted_successfully', ['module' => __('admin.faq_group')]))->success();
        return back();
    }

    public function list(): JsonResponse
    {
        return $this->service->list();
    }
}
