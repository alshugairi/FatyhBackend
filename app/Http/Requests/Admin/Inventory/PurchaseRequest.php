<?php

namespace App\Http\Requests\Admin\Inventory;

use App\Enums\PurchaseStatus;
use Illuminate\{Foundation\Http\FormRequest};

class PurchaseRequest extends FormRequest
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
        return [
            'number' => 'required|string|max:255',
            'date' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'status' => 'required|in:' . implode(',', PurchaseStatus::values()),
            'notes' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'items' => 'required|array',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.product_variant_id' => 'nullable|integer|exists:product_variants,id',
            'items.*.description' => 'nullable|string',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.tax' => 'nullable|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0',
        ];
    }
}
