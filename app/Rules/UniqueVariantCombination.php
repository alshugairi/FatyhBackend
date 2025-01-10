<?php

namespace App\Rules;

use App\Models\ProductVariant;
use App\Models\ProductVariantAttribute;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueVariantCombination implements ValidationRule
{
    private $product;

    public function __construct($product)
    {
        $this->product = $product;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_array($value)) {
            $fail(__('validation.variant_combination_invalid'));
            return;
        }

        $attributeOptions = collect($value)
            ->filter(fn($variant) => !is_null($variant['option_id']))
            ->pluck('option_id')
            ->toArray();

        if (empty($attributeOptions)) {
            $fail(__('validation.variant_combination_invalid'));
            return;
        }

        $variantId = ProductVariantAttribute::select('product_variant_id')
            ->whereIn('attribute_option_id', $attributeOptions)
            ->whereHas('productVariant', function($query) {
                $query->where('product_id', $this->product->id);
            })
            ->groupBy('product_variant_id')
            ->havingRaw('COUNT(DISTINCT attribute_option_id) = ?', [count($attributeOptions)])
            ->first();

        if ($variantId) {
            $existingVariant = ProductVariant::with('attributeOptions.attribute')
                ->find($variantId->product_variant_id);

            $combinationString = $existingVariant->attributeOptions
                ->map(function($option) {
                    return $option->attribute->name . ': ' . $option->name;
                })
                ->join(', ');

            $fail(__('validation.variant_combination_exists', [
                'combination' => $combinationString
            ]));
        }
    }
}
