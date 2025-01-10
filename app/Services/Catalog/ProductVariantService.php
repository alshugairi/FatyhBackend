<?php

namespace App\Services\Catalog;

use App\Repositories\Catalog\ProductVariantRepository;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductVariantService extends BaseService
{
    public function __construct(ProductVariantRepository $repository,
                                private readonly ProductVariantAttributeService $productVariantAttributeService,
                                private readonly ProductService $productService,
    )
    {
        parent::__construct($repository);
    }

    public function create(array $data): Model
    {
        return DB::transaction(function () use ($data) {
            $variant = parent::create($data);

            if (isset($data['attributes'])) {
                $variantAttributes = [];

                foreach ($data['attributes'] as $attributeId => $attribute) {
                    if (!is_null($attribute['option_id'])) {
                        $variantAttributes[] = [
                            'product_variant_id' => $variant->id,
                            'attribute_id' => $attributeId,
                            'attribute_option_id' => $attribute['option_id'],
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                    }
                }

                if (!empty($variantAttributes)) {
                    $this->productVariantAttributeService->insert($variantAttributes);
                }
            }

            $variant->load('attributeOptions');

            $variant['names'] = $variant->attributeOptions->map(function($opt) {
                return $opt->name;
            })->join(' | ');

            $variant['formatted_price'] = format_currency($variant['sell_price']);

            $this->productService->update(data: ['has_variants' => true], id: $data['product_id']);

            return $variant;
        });
    }

    public function delete($id): bool
    {
        return DB::transaction(function () use ($id) {
            $product = $this->productService->find($id);
            if (!$product->variants) {
                $this->productService->update(data: ['has_variants' => false], id: $product->id);
            }
            return parent::delete(id: $id);
        });
    }
}
