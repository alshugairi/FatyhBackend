<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\{Http\Controllers\Controller,
    Http\Requests\Admin\Catalog\BrandRequest,
    Models\Brand,
    Services\Catalog\BrandService};
use Exception;
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse};
use Illuminate\Http\Request;

class BrandController extends Controller
{
        /**
         * @param BrandService $service
         */
        public function __construct(private readonly BrandService $service)
        {
        }

        /**
         * @return View
         */
        public function index(): View
        {
            return view('admin.modules.catalog.brands.index', get_defined_vars());
        }

        /**
         * @return View
         */
        public function create(): View
        {
            return view('admin.modules.catalog.brands.create', get_defined_vars());
        }

        /**
         * @param BrandRequest $request
         * @return RedirectResponse
         */
        public function store(BrandRequest $request): RedirectResponse
        {
            $data = $request->validated();
            if (isset($data['image'])) {
                $data['image'] = upload_file($data['image'], 'catalog/brands');
            }
            $this->service->create(data: $data);
            flash(__('admin.created_successfully', ['module' => __('admin.brand')]))->success();
            return redirect()->route(route: 'admin.brands.index');
        }

        /**
         * @param Brand $brand
         * @return View
         */
        public function edit(Brand $brand): View
        {
            return view('admin.modules.catalog.brands.edit', get_defined_vars());
        }

        /**
         * @param BrandRequest $request
         * @param Brand $brand
         * @return RedirectResponse
         */
        public function update(BrandRequest $request, Brand $brand): RedirectResponse
        {
            $data = $request->validated();
            if (isset($data['image'])) {
                $data['image'] = upload_file($data['image'], 'catalog/brands');
            }
            $this->service->update(data: $data, id: $brand->id);
            flash(__('admin.updated_successfully', ['module' => __('admin.brand')]))->success();
            return redirect()->route(route: 'admin.brands.index');
        }

        /**
         * @param Brand $brand
         * @return RedirectResponse
         * @throws Exception
         */
        public function destroy(Brand $brand): RedirectResponse
        {
            $this->service->delete(id: $brand->id);
            flash(__('admin.deleted_successfully', ['module' => __('admin.brand')]))->success();
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
