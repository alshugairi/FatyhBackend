<?php

namespace App\Models;

use App\Traits\ModelAttributesTrait;
use Illuminate\{Database\Eloquent\Factories\HasFactory,
    Database\Eloquent\Model,
    Database\Eloquent\SoftDeletes};

class StockMovement extends Model
{
    use HasFactory, ModelAttributesTrait;

    protected $table = 'stock_movements';

    protected $fillable = [
        'product_id',
        'product_variant_id',
        'reference_type',
        'reference_id',
        'type',
        'quantity_change',
        'quantity_before',
        'quantity_after',
        'notes',
        'metadata',
        'movement_date',
        'creator_id'
    ];

    protected $casts = [
        'product_id' => 'int',
        'product_variant_id' => 'int',
        'reference_type' => 'string',
        'reference_id' => 'string',
        'type' => 'string',
        'quantity_change' => 'int',
        'quantity_before' => 'int',
        'quantity_after' => 'int',
        'notes' => 'string',
        'metadata' => 'json',
        'movement_date' => 'datetime',
        'creator_id' => 'int'
    ];

    protected $appends = [
        'formatted_created_at'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
