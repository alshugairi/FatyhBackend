<?php

namespace App\Http\Resources\Catalog;

use Illuminate\Http\Resources\Json\JsonResource;

class AttributeOptionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'attribute' => new AttributeResource($this->whenLoaded('attribute')),
            'value' => $this->value,
            'position' => $this->position,
        ];
    }
}
