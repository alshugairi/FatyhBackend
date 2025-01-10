<?php

namespace App\Models;

use App\Traits\ModelAttributesTrait;
use Illuminate\{Database\Eloquent\Factories\HasFactory,
    Database\Eloquent\Model,
    Database\Eloquent\SoftDeletes};

class ProductVariant extends Model
{
    use HasFactory, SoftDeletes, ModelAttributesTrait;

    protected $table = 'product_variants';

    protected $fillable = [
        'product_id',
        'sku',
        'sell_price',
        'stock_quantity',
        'weight',
        'length',
        'width',
        'height',
        'is_active',
        'image',
        'image_urls'
    ];

    protected $casts = [
        'product_id' => 'int',
        'sku' => 'int',
        'sell_price' => 'float',
        'stock_quantity' => 'int',
        'weight' => 'float',
        'length' => 'float',
        'width' => 'float',
        'height' => 'float',
        'is_active' => 'bool',
        'image' => 'string',
        'image_urls' => 'array'
    ];

    protected $appends = [
        'formatted_created_at'
    ];

    public function attributeOptions()
    {
        return $this->belongsToMany(AttributeOption::class, 'product_variant_attributes')
            ->withPivot('attribute_id')
            ->with('attribute')
            ->orderBy('position');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public static function hasCombination($productId, array $attributeOptionIds): bool
    {
        $variantsCount = self::where('product_id', $productId)
            ->whereHas('attributeOptions', function ($query) use ($attributeOptionIds) {
                $query->whereIn('attribute_options.id', $attributeOptionIds);
            }, '=', count($attributeOptionIds))
            ->count();

        return $variantsCount > 0;
    }

    public function getAttributeCombinationAttribute(): string
    {
        return $this->attributeOptions->map(function($option) {
            return $option->attribute->name . ': ' . $option->name;
        })->join(', ');
    }

    public function variantAttributes()
    {
        return $this->hasMany(ProductVariantAttribute::class);
    }

    public function attributes()
    {
        return $this->belongsToMany(AttributeModel::class, 'product_variant_attributes', 'product_variant_id','attribute_id')
                    ->withPivot('attribute_option_id');
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function stockReservations()
    {
        return $this->hasMany(StockReservation::class);
    }

    public function stockAlerts()
    {
        return $this->hasMany(StockAlert::class);
    }

    public function updateStock(int $quantity, string $type, string $referenceType = null, string $referenceId = null, array $metadata = [])
    {
        $quantityBefore = $this->stock_quantity;
        $quantityAfter = $quantityBefore + $quantity;

        $this->stock_quantity = $quantityAfter;
        $this->save();

        return $this->stockMovements()->create([
            'type' => $type,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
            'quantity_change' => $quantity,
            'quantity_before' => $quantityBefore,
            'quantity_after' => $quantityAfter,
            'metadata' => $metadata,
            'movement_date' => now(),
            'creator_id' => auth()->id()
        ]);
    }
}
