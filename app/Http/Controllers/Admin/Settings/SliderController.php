<?php

namespace App\Http\Controllers\Admin\Settings;

use App\{Http\Controllers\Controller,
    Http\Requests\Admin\Settings\SliderRequest,
    Models\Post,
    Pipelines\Settings\PostFilterPipeline,
    Services\Settings\PostService};
use Exception;
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse};
use Illuminate\Http\Request;

class SliderController extends Controller
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
        return view('admin.modules.settings.sliders.index', get_defined_vars());
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('admin.modules.settings.sliders.create', get_defined_vars());
    }

    /**
     * @param SliderRequest $request
     * @return RedirectResponse
     */
    public function store(SliderRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['image'] = upload_file($data['image'], 'settings/slider');
        $data['type'] = 'slider';
        $this->service->create(data: $data);
        flash(__('admin.created_successfully', ['module' => __('admin.slider')]))->success();
        return redirect()->route(route: 'admin.sliders.index');
    }

    /**
     * @param Post $slider
     * @return View
     */
    public function edit(Post $slider): View
    {
        return view('admin.modules.settings.sliders.edit', get_defined_vars());
    }

    /**
     * @param SliderRequest $request
     * @param Post $slider
     * @return RedirectResponse
     */
    public function update(SliderRequest $request, Post $slider): RedirectResponse
    {
        $data = $request->validated();
        if (isset($data['image'])) {
            $data['image'] = upload_file($data['image'], 'settings/slider');
        }
        $this->service->update(data: $data, id: $slider->id);
        flash(__('admin.updated_successfully', ['module' => __('admin.slider')]))->success();
        return redirect()->route(route: 'admin.sliders.index');
    }

    /**
     * @param Post $slider
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Post $slider): RedirectResponse
    {
        $this->service->delete(id: $slider->id);
        flash(__('admin.deleted_successfully', ['module' => __('admin.slider')]))->success();
        return back();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function list(Request $request): JsonResponse
    {
        $request->merge(['type' => 'slider']);
        return $this->service->list(filters: [
            new PostFilterPipeline(request: $request),
        ]);
    }
}
