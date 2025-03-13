<?php

namespace App\Http\Resources;

use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessProductsResource extends JsonResource
{
    public function __construct($resource)
    {
        parent::__construct($resource);
    }

    public function toArray(Request $request): ?array
    {
        if (is_null($this->resource)) {
            return [];
        }

        return [
            'id' => $this->id,
            'items' => CartItemResource::collection($this->items),
            "subtotal" => "103.96 IQD",
            "shipping" => "0 IQD",
            "discount" => "15.00 IQD",
            "promotionTotal" => "15.00 IQD",
            "promotions" => [
                [
                    "description" => "30% Discount on Polo Neck",
                    "image" => "/images/t1.png",
                    "amount" => "9.00 IQD"
                ],
                [
                    "description" => "10% Off First Order",
                    "image" => "/images/t2.png",
                    "amount" => "6.00 IQD"
                ]
            ],
            "total" => "10 IQD"
        ];
    }
}
