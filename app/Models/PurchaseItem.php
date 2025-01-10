<?php

namespace App\Models;

use Illuminate\{Database\Eloquent\Factories\HasFactory, Database\Eloquent\Model};

class PurchaseItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'product_id',
        'product_variant_id',
        'description',
        'unit_price',
        'quantity',
        'received_quantity',
        'subtotal',
        'discount',
        'tax',
        'total',
    ];

    protected $casts = [
        'purchase_id' => 'integer',
        'product_id' => 'integer',
        'product_variant_id' => 'integer',
        'description' => 'string',
        'unit_price' => 'decimal:2',
        'quantity' => 'integer',
        'received_quantity' => 'integer',
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
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
