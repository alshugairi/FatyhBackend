<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'number' => $this->number,
            'customer' => [
                'name' => $this->customer_name,
                'email' => $this->customer_email,
                'phone' => $this->customer_phone,
            ],
            'billing_address' => [
                'address' => $this->billing_address,
                'city' => $this->billing_city,
                'state' => $this->billing_state,
                'country' => $this->billing_country,
                'postcode' => $this->billing_postcode,
            ],
            'payment' => [
                'method' => $this->payment_method,
                'status' => $this->payment_status,
                'transaction_id' => $this->payment_id,
                'paid_amount' => format_price($this->paid_amount),
            ],
            'subtotal' => format_price($this->subtotal),
            'shipping' => format_price($this->shipping_cost),
            'tax' => format_price($this->tax),
            'discount' => format_price($this->discount),
            'total' => format_price($this->total),
            'status' => $this->status->value,
            'items' => OrderItemResource::collection($this->items),
            'tracking_number' => $this->tracking_number,
            'shipping_method' => $this->shipping_method,
            'customer_notes' => $this->customer_notes,
            'admin_notes' => $this->admin_notes,
            'platform' => $this->platform->value,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
