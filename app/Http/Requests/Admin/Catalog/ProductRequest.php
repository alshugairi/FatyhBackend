<?php

namespace App\Http\Requests\Admin\Catalog;

use Illuminate\{Foundation\Http\FormRequest};

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $product = $this->route('product');
        return [
            'name' => ['required', 'array'],
            'name.*' => ['required', 'string', 'max:255'],

            'sku' => ['required', 'string', 'max:100', 'unique:products,sku,' . $product?->id],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug,' . $product?->id],

            'description' => ['nullable', 'array'],
            'description.*' => ['nullable', 'string', 'max:1000'],

            'short_description' => ['nullable', 'array'],
            'short_description.*' => ['nullable', 'string', 'max:1000'],

            'status' => ['sometimes', 'boolean'],
            'barcode' => ['nullable', 'string', 'max:255'],

            'sell_price' => ['required', 'numeric', 'min:0'],
            'purchase_price' => ['required', 'numeric', 'min:0'],
            'discount_price' => ['nullable', 'numeric', 'min:0', 'lte:sell_price'],

            'stock_quantity' => ['sometimes', 'boolean'],

            //'type' => ['required', 'string', 'in:simple,variant'],

            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'brand_id' => ['nullable', 'integer', 'exists:brands,id'],
            'parent_product_id' => ['nullable', 'integer', 'exists:products,id'],

            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:3048'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['nullable', 'string'],

            'meta_title' => ['nullable', 'array'],
            'meta_title.*' => ['nullable', 'string', 'max:255'],

            'meta_description' => ['nullable', 'array'],
            'meta_description.*' => ['nullable', 'string', 'max:1000'],

            'meta_keywords' => ['nullable', 'array'],
            'meta_keywords.*' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'status' => $this->boolean('status', false),
            'stock_quantity' => $this->boolean('stock_quantity', false),
        ]);
    }
}
