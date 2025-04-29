<?php

namespace App\Http\Resources\Catalog;

use App\Http\Resources\BusinessResource;
use App\Http\Resources\Catalog\ImageResource;
use App\Http\Resources\Catalog\VariantResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailsResource extends JsonResource
{
    public function toArray($request)
    {
        $attributes = $this->getAttributesAndOptions();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'sku' => $this->sku,
            'slug' => $this->slug,
            'description' => $this->description,
            'short_description' => $this->short_description,
            'rating' => $this->rating,
            'reviews_count' => $this->reviews_count,
            'sell_price' => $this->sell_price,
            'discount_price' => $this->discount_price,
            'stock_quantity' => $this->stock_quantity,
            'is_wishlisted' => $this->is_wishlisted,
            'created_at' => $this->formatted_created_at,
            'items_sold_count' => 0,
            'items_sold_days' => 0,
            'lowest_price_days' => 0,
            'image' => $this->image,
            'gallery_images' => $this->gallery_images,
            'business' => new BusinessResource($this->whenLoaded('business')),
            'images' => ImageResource::collection($this->whenLoaded('images')),
            'variants' => VariantResource::collection($this->whenLoaded('variants')),
            'attributes' => $attributes,
        ];
    }

    protected function getAttributesAndOptions()
    {
        $attributes = [];

        // Check if variants are loaded
        if (!$this->relationLoaded('variants')) {
            return $attributes;
        }

        // Iterate through variants and their attribute options
        foreach ($this->variants as $variant) {
            if (!$variant->relationLoaded('attributeOptions')) {
                continue;
            }

            foreach ($variant->attributeOptions as $option) {
                if (!$option->relationLoaded('attribute')) {
                    continue;
                }

                $attributeId = $option->attribute->id;
                $attributeName = $option->attribute->name;

                // Initialize the attribute if not already present
                if (!isset($attributes[$attributeId])) {
                    $attributes[$attributeId] = [
                        'id' => $attributeId,
                        'name' => $attributeName,
                        'type' => $option->attribute->type,
                        'options' => [],
                    ];
                }

                // Add the option if not already present
                $optionId = $option->id;
                if (!isset($attributes[$attributeId]['options'][$optionId])) {
                    $attributes[$attributeId]['options'][$optionId] = [
                        'id' => $optionId,
                        'name' => $option->name,
                        'value' => $option->value,
                    ];
                }
            }
        }

        // Convert options to a list and sort attributes by position or ID
        $attributes = array_values($attributes);
        foreach ($attributes as &$attribute) {
            $attribute['options'] = array_values($attribute['options']);
        }

        // Sort attributes by position or ID
        usort($attributes, function ($a, $b) {
            return ($a['id'] <=> $b['id']);
        });

        return $attributes;
    }
}
