<?php

namespace App\Http\Resources\Catalog;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VariantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'sell_price' => $this->sell_price,
            'stock_quantity' => $this->stock_quantity,
            'image' => $this->image,
            'image_urls' => $this->image_urls,
            'attribute_combination' => $this->attribute_combination, // E.g., "Color: Red, Size: Medium"
            'attributes' => AttributeOptionResource::collection($this->whenLoaded('attributeOptions')),
            'is_active' => $this->is_active,
            'created_at' => $this->formatted_created_at,
        ];
    }
}
