<?php

namespace App\Http\Resources\Catalog;

use Illuminate\{Http\Request, Http\Resources\Json\JsonResource};

class ImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'image' => get_full_image_url($this->image_path),
        ];
    }
}
