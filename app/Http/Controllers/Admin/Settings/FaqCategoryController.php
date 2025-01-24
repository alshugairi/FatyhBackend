<?php

namespace App\Http\Controllers\Admin\Settings;

use App\{Http\Controllers\Controller,
    Http\Requests\Admin\Settings\FaqCategoryRequest,
    Models\FaqCategory,
    Services\Settings\FaqCategoryService};
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse};

class FaqCategoryController extends Controller
{
    public function __construct(private readonly FaqCategoryService $service)
    {
    }

    public function index(): View
    {
        return view('admin.modules.settings.faq_categories.index', get_defined_vars());
    }

    public function create(): View
    {
        return view('admin.modules.settings.faq_categories.create', get_defined_vars());
    }

    public function store(FaqCategoryRequest $request): RedirectResponse
    {
        $this->service->create(data: array_merge($request->validated(), ['type' => 'faq_category']));
        flash(__('admin.created_successfully', ['module' => __('admin.faq')]))->success();
        return redirect()->route(route: 'admin.faq_categories.index');
    }

    public function edit(FaqCategory $faqCategory): View
    {
        return view('admin.modules.settings.faq_categories.edit', get_defined_vars());
    }

    public function update(FaqCategoryRequest $request, FaqCategory $faqCategory): RedirectResponse
    {
        $this->service->update(data: $request->validated(), id: $faqCategory->id);
        flash(__('admin.updated_successfully', ['module' => __('admin.faq_category')]))->success();
        return redirect()->route(route: 'admin.faq_categories.index');
    }

    public function destroy(FaqCategory $faqCategory): RedirectResponse
    {
        $this->service->delete(id: $faqCategory->id);
        flash(__('admin.deleted_successfully', ['module' => __('admin.faq_category')]))->success();
        return back();
    }

    public function list(): JsonResponse
    {
        return $this->service->list();
    }
}
