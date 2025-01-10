<?php

namespace App\Services\Inventory;

use App\Models\Product;
use App\Repositories\Catalog\ProductRepository;
use App\Services\BaseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class InventoryService extends BaseService
{
    public function __construct(ProductRepository $repository)
    {
        parent::__construct($repository);
    }


    public function list(array $filters = [], array $relations = [], array $withCount = []): JsonResponse
    {
        $query = $this->repository->getModel()
            ->select([
                'products.id',
                'products.name',
                'products.sku',
                'products.stock_quantity',
                'products.has_variants',
                'product_variants.id as variant_id',
                'product_variants.sku as variant_sku',
                'product_variants.stock_quantity as variant_stock_quantity',
                DB::raw("GROUP_CONCAT(DISTINCT JSON_UNQUOTE(JSON_EXTRACT(attribute_options.name, '$." . app()->getLocale() . "')) ORDER BY attributes.id) as variant_name")
            ])
            ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->leftJoin('product_variant_attributes', 'product_variants.id', '=', 'product_variant_attributes.product_variant_id')
            ->leftJoin('attribute_options', 'product_variant_attributes.attribute_option_id', '=', 'attribute_options.id')
            ->leftJoin('attributes', 'attribute_options.attribute_id', '=', 'attributes.id')
            ->groupBy('products.id', 'product_variants.id')
            ->orderBy('products.id');

        return DataTables::of(app(Pipeline::class)->send($query)->through($filters)->thenReturn())
            ->editColumn('name', function ($item) {
                if (!$item->has_variants) {
                    return $item->name;
                }
                return $item->name . '(' . str_replace(',', ' | ', $item->variant_name) . ')';
            })
            ->editColumn('sku', function ($item) {
                return !$item->has_variants ? $item->sku : $item->variant_sku;
            })
            ->editColumn('stock_quantity', function ($item) {
                return !$item->has_variants ? $item->stock_quantity : $item->variant_stock_quantity;
            })
            ->rawColumns(['name'])
            ->toJson();
    }
}
