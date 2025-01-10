<?php

namespace App\Http\Resources\Catalog;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'price' => $this->sell_price,
            'formatted_price' => format_currency($this->sell_price),
            'original_price' => $this->original_price,
            'rating' => 3,
            'image' => get_full_image_url($this->image),
        ];
    }
}
