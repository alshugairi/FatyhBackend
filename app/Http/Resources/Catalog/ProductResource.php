<?php

namespace App\Http\Resources\Catalog;

use App\Http\Resources\BusinessResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Review;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $attributes = $this->getAttributesAndOptions();

        $oldPrice = $this->discount_price ? $this->sell_price + $this->discount_price : $this->sell_price;
        $discountPercentage = null;
        if ($this->discount_price && $this->discount_price < $this->sell_price) {
            $discountPercentage = round(
                ($this->discount_price / $oldPrice) * 100,
                2
            );
        }

        $reviewCounts = $this->getReviewCountsByStar();

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
            'old_price' => $oldPrice,
            'discount_percentage' => $discountPercentage,
            'price' => $this->sell_price,
            'formatted_price' => format_currency($this->sell_price),
            'stock_quantity' => $this->stock_quantity,
            'is_wishlisted' => $this->is_wishlisted,
            'favourites_count' => $this->favourites_count,
            'created_at' => $this->formatted_created_at,
            'items_sold_count' => 0,
            'items_sold_days' => 0,
            'lowest_price_days' => 0,
            'image' => get_full_image_url($this->image),
            'gallery_images' => $this->gallery_images,
            'business' => new BusinessResource($this->whenLoaded('business')),
            'images' => ImageResource::collection($this->whenLoaded('images')),
            'variants' => VariantResource::collection($this->whenLoaded('variants')),
            'attributes' => $attributes,
            'review_counts' => [
                'star_1' => $reviewCounts[1] ?? 0,
                'star_2' => $reviewCounts[2] ?? 0,
                'star_3' => $reviewCounts[3] ?? 0,
                'star_4' => $reviewCounts[4] ?? 0,
                'star_5' => $reviewCounts[5] ?? 0,
            ],
        ];
    }

    /**
     * Get the count of reviews for each star rating (1 to 5).
     *
     * @return array
     */
    protected function getReviewCountsByStar(): array
    {
        return $this->reviews
            ->groupBy('rating')
            ->mapWithKeys(function ($reviews, $rating) {
                return [$rating => count($reviews)];
            })->toArray();
    }

    /**
     * Get attributes and options for variants.
     *
     * @return array
     */
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
