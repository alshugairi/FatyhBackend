<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function toArray(Request $request): ?array
    {
        if (is_null($this->resource)) {
            return [];
        }

        return [
            'id' => $this->id,
            'product' => [
                'id' => $this->product->id,
                'name' => $this->product->name,
                'image' => get_full_image_url($this->product->image),
                'sku' => $this->sku,
                'variant' => optional($this->productVariant)->name,
            ],
            'unit_price' => format_price($this->unit_price),
            'quantity' => $this->quantity,
            'subtotal' => format_price($this->subtotal),
            'tax' => format_price($this->tax),
            'discount' => format_price($this->discount),
            'total' => format_price($this->total),
            'options' => $this->options,
        ];
    }
}
