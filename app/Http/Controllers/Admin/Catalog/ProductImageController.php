<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\{Http\Controllers\Controller,
    Http\Requests\Admin\Catalog\ProductImageRequest,
    Models\Product,
    Models\ProductImage,
    Services\Catalog\ProductImageService,
    Utils\HttpFoundation\Response};
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function __construct(private readonly ProductImageService $productImageService)
    {
    }

    public function uploadImage(ProductImageRequest $request, Product $product): Response
    {
        $nextPositionNumber = $this->productImageService->getNextPositionNumberByProductId(productId: $product->id);
        $data = $request->validated();
        $data['product_id'] = $product->id;
        $data['image_path'] = upload_file($data['image_file'], 'catalog/products');
        $data['position'] = $nextPositionNumber;
        $productImage = $this->productImageService->create(data: $data);
        return Response::response(
            message: __('admin.success_upload'),
            data: ['id' => $productImage->id, 'image_path' => get_full_image_url($productImage->image_path)]
        );
    }

    public function reorderImages(Request $request, $productId)
    {
        $positions = $request->input('positions');

        foreach ($positions as $position) {
            ProductImage::where('id', $position['id'])->update(['position' => $position['position']]);
        }

        return Response::response(
            message: __('admin.success_reorder'),
        );
    }
}
