<?php

namespace App\Http\Resources\Catalog;

use App\Http\Resources\BusinessResource;
use Illuminate\{Http\Request, Http\Resources\Json\JsonResource};

class ProductDetailsResource extends JsonResource
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
            'description' => $this->description,
            'image' => get_full_image_url($this->image),
            'business' => new BusinessResource($this->business),
            'images' => ImageResource::collection($this->images),
        ];
    }
}
