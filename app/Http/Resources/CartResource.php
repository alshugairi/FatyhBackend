<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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

        $subtotal = $this->calculateSubtotal($this->items);
        $discount = 0;
        $shipping = 0;

        $total = $subtotal - $discount + $shipping;

        return [
            'id' => $this->id,
            'items' => $this->getItems($this->items),
            "subtotal" => format_price($subtotal),
            "shipping" => format_price($shipping),
            "discount" => format_price($discount),
            "promotionTotal" => format_price($discount),
            "promotions" => [
//                [
//                    "description" => "30% Discount on Polo Neck",
//                    "image" => "/images/t1.png",
//                    "amount" => "9.00 IQD"
//                ],
            ],
            "total" => format_price($total)
        ];
    }

    public function getItems($items)
    {
        $groupedByBusiness = $items->groupBy(fn($item) => $item->product->business->id);

        return $groupedByBusiness->map(function ($products) {
            $business = $products->first()->product->business;

            return [
                'seller' => new BusinessResource($business),
                'products' => $products->map(fn($item) => [
                    'id' => $item->product->id,
                    'name' => $item->product->name,
                    'image' => get_full_image_url($item->product->image),
                    'delivery' => 'Delivery 2-5 days',
                    'size' => $item->size,
                    'discount' => $item->product->discount . '%',
                    'price' => $item->price,
                    'originalPrice' => $item->product->original_price,
                    'quantity' => $item->quantity
                ])
            ];
        })->values();
    }

    private function calculateSubtotal($items)
    {
        return $items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }
}

