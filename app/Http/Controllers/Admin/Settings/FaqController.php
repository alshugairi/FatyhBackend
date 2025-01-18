<?php

namespace App\Http\Controllers\Admin\Settings;

use App\{Http\Controllers\Controller,
    Http\Requests\Admin\Settings\FaqRequest,
    Models\Faq,
    Models\FaqGroup,
    Services\Settings\FaqService};
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse};
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function __construct(private readonly FaqService $service)
    {
    }

    public function index(): View
    {
        return view('admin.modules.settings.faqs.index', get_defined_vars());
    }

    public function create(): View
    {
        $faqGroups = FaqGroup::toSelect();
        return view('admin.modules.settings.faqs.create', get_defined_vars());
    }

    public function store(FaqRequest $request): RedirectResponse
    {
        $this->service->create(data: array_merge($request->validated(), ['type' => 'faq']));
        flash(__('admin.created_successfully', ['module' => __('admin.faq')]))->success();
        return redirect()->route(route: 'admin.faqs.index');
    }

    public function edit(Faq $faq): View
    {
        $faqGroups = FaqGroup::toSelect();
        return view('admin.modules.settings.faqs.edit', get_defined_vars());
    }

    public function update(FaqRequest $request, Faq $faq): RedirectResponse
    {
        $this->service->update(data: $request->validated(), id: $faq->id);
        flash(__('admin.updated_successfully', ['module' => __('admin.faq')]))->success();
        return redirect()->route(route: 'admin.faqs.index');
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $this->service->delete(id: $faq->id);
        flash(__('admin.deleted_successfully', ['module' => __('admin.faq')]))->success();
        return back();
    }

    public function list(Request $request): JsonResponse
    {
        return $this->service->list(relations: ['group']);
    }
}
