<?php

namespace App\Models;

use Illuminate\{Database\Eloquent\Factories\HasFactory, Database\Eloquent\Model};

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_variant_id',
        'name',
        'sku',
        'unit_price',
        'quantity',
        'subtotal',
        'tax',
        'discount',
        'total',
        'options',
    ];

    protected $casts = [
        'order_id' => 'integer',
        'product_id' => 'integer',
        'product_variant_id' => 'integer',
        'name' => 'string',
        'sku' => 'string',
        'unit_price' => 'decimal:2',
        'quantity' => 'integer',
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'options' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
