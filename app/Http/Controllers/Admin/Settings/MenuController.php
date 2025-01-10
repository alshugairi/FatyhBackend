<?php

namespace App\Http\Controllers\Admin\Settings;

use App\{Enums\PostType,
    Http\Controllers\Controller,
    Http\Requests\Admin\Settings\MenuRequest,
    Models\Brand,
    Models\Category,
    Models\Menu,
    Models\Post,
    Services\Settings\MenuService};
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse, Support\Str};
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function __construct(private readonly MenuService $service)
    {
    }

    public function index(): View
    {
        return view('admin.modules.settings.menus.index', get_defined_vars());
    }

    public function create(): View
    {
        $pages = Post::where('type', PostType::PAGE->value)->get();
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.modules.settings.menus.create', get_defined_vars());
    }

    public function store(MenuRequest $request): RedirectResponse
    {
        $this->service->create(data: $request->validated());
        flash(__('admin.created_successfully', ['module' => __('admin.menu')]))->success();
        return redirect()->route(route: 'admin.menus.index');
    }

    public function edit(Menu $menu): View
    {
        $pages = Post::where('type', PostType::PAGE->value)->get();
        $categories = Category::all();
        $brands = Brand::all();
        $menu->load('items.children');

        $counter = 1;
        $formattedItems = $this->service->formatMenuItems($menu->items, $counter);

        return view('admin.modules.settings.menus.edit', get_defined_vars());
    }

    public function update(MenuRequest $request, Menu $menu): RedirectResponse
    {
        $this->service->update(data: $request->validated(), id: $menu->id);
        flash(__('admin.updated_successfully', ['module' => __('admin.menu')]))->success();
        return redirect()->route(route: 'admin.menus.index');
    }

    public function destroy(Menu $menu): RedirectResponse
    {
        $this->service->delete(id: $menu->id);
        flash(__('admin.deleted_successfully', ['module' => __('admin.menu')]))->success();
        return back();
    }

    public function list(Request $request): JsonResponse
    {
        return $this->service->list();
    }
}
