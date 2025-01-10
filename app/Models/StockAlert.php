<?php

namespace App\Models;

use App\Traits\ModelAttributesTrait;
use Illuminate\{Database\Eloquent\Factories\HasFactory,
    Database\Eloquent\Model,
    Database\Eloquent\SoftDeletes};

class StockAlert extends Model
{
    use HasFactory, SoftDeletes, ModelAttributesTrait;

    protected $table = 'stock_movements';

    protected $fillable = [
        'product_variant_id',
        'attribute_id',
        'attribute_option_id',
    ];

    protected $casts = [
        'product_variant_id' => 'int',
        'attribute_id' => 'int',
        'attribute_option_id' => 'int',
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
}
