<?php

namespace App\Http\Requests\Admin\Catalog;

use App\Models\AttributeModel;
use App\Rules\UniqueVariantCombination;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductVariantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'sku' => 'required|string|unique:product_variants,sku',
            'sell_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'attributes' => ['required', 'array', new UniqueVariantCombination($this->route('product'))],
        ];

        $attributes = AttributeModel::where('status', 1)->get();

        foreach ($attributes as $attribute) {
            $attributeRule = $attribute->is_required
                ? ['required', Rule::exists('attribute_options', 'id')->where('attribute_id', $attribute->id)]
                : ['nullable', Rule::exists('attribute_options', 'id')->where('attribute_id', $attribute->id)];

            $rules["attributes.{$attribute->id}.option_id"] = $attributeRule;
        }

        return $rules;
    }

    public function messages(): array
    {
        $attributes = AttributeModel::where('status', 1)->get();

        foreach ($attributes as $attribute) {
            $messages["attributes.{$attribute->id}.option_id.required"] = __('validation.attribute_option_required', ['attribute' => $attribute->name]);
            $messages["attributes.{$attribute->id}.option_id.exists"] = __('validation.attribute_option_exists', ['attribute' => $attribute->name]);
        }

        return $messages;
    }
}
