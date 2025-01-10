<?php

namespace App\Http\Controllers\Admin\Settings;

use App\{Http\Controllers\Controller,
    Http\Requests\Admin\Settings\LanguageRequest,
    Models\Language,
    Services\Settings\LanguageService};
use Exception;
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse};
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * @param LanguageService $service
     */
    public function __construct(private readonly LanguageService $service)
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('admin.modules.settings.languages.index', get_defined_vars());
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('admin.modules.settings.languages.create', get_defined_vars());
    }

    /**
     * @param LanguageRequest $request
     * @return RedirectResponse
     */
    public function store(LanguageRequest $request): RedirectResponse
    {
        $this->service->create(data: $request->validated());
        flash(__('admin.language').' '.__('admin.created_successfully'))->success();
        return redirect()->route(route: 'admin.languages.index');
    }

    /**
     * @param Language $language
     * @return View
     */
    public function edit(Language $language): View
    {
        return view('admin.modules.settings.languages.edit', get_defined_vars());
    }

    /**
     * @param LanguageRequest $request
     * @param Language $language
     * @return RedirectResponse
     */
    public function update(LanguageRequest $request, Language $language): RedirectResponse
    {
        $this->service->update(data: $request->validated(), id: $language->id);
        flash(__('admin.language').' '.__('admin.updated_successfully'))->success();
        return redirect()->route(route: 'admin.languages.index');
    }

    /**
     * @param Language $language
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Language $language): RedirectResponse
    {
        $this->service->delete(id: $language->id);
        flash(__('admin.language').' '.__('admin.deleted_successfully'))->success();
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
