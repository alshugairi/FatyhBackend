<?php

namespace App\Models;

use App\Traits\ModelAttributesTrait;
use Illuminate\{Database\Eloquent\Factories\HasFactory,
    Database\Eloquent\Model,
    Database\Eloquent\SoftDeletes};

class ProductVariantAttribute extends Model
{
    use HasFactory, ModelAttributesTrait;

    protected $table = 'product_variant_attributes';

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

    public function attribute()
    {
        return $this->belongsTo(AttributeModel::class, 'attribute_id');
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function attributeOption()
    {
        return $this->belongsTo(AttributeOption::class, 'attribute_option_id');
    }
}
