<?php

namespace App\Http\Requests\Admin\Sales;

use Illuminate\{Foundation\Http\FormRequest, Validation\Rule};

class OrderRequest extends FormRequest
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
            'user_id' => 'nullable|integer|exists:users,id',
            'customer_name' => ['nullable', 'string', 'max:255'],
            'customer_email' => ['nullable', 'email', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:20'],

            'subtotal' => ['required', 'numeric', 'min:0', 'max:9999999.99'],
            'tax' => ['required', 'numeric', 'min:0', 'max:9999999.99'],
            'discount' => ['nullable', 'numeric', 'min:0', 'max:9999999.99'],
            'total' => ['required', 'numeric', 'min:0', 'max:9999999.99'],

            'payment_method' => ['nullable', Rule::in(['cash', 'card', 'bank_transfer'])],
            'payment_status' => ['nullable', Rule::in(['pending', 'paid', 'failed'])],

            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required','integer',Rule::exists('products', 'id')],
            'items.*.name' => ['required', 'string', 'max:255'],
            'items.*.price' => ['required', 'numeric', 'min:0', 'max:9999999.99'],
            'items.*.quantity' => ['required', 'integer', 'min:1', 'max:9999'],

            'billing_address' => ['nullable', 'string', 'max:500'],
            'billing_city' => ['nullable', 'string', 'max:100'],
            'billing_state' => ['nullable', 'string', 'max:100'],
            'billing_country' => ['nullable', 'string', 'max:100'],
            'billing_postcode' => ['nullable', 'string', 'max:20'],

            'shipping_address' => ['nullable', 'string', 'max:500'],
            'shipping_city' => ['nullable', 'string', 'max:100'],
            'shipping_state' => ['nullable', 'string', 'max:100'],
            'shipping_country' => ['nullable', 'string', 'max:100'],
            'shipping_postcode' => ['nullable', 'string', 'max:20'],

            'customer_notes' => ['nullable', 'string', 'max:1000'],
            'admin_notes' => ['nullable', 'string', 'max:1000'],
            'discount_code' => ['nullable', 'string', 'max:50'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(array_map(function ($value) {
            return $value === '' ? null : $value;
        }, $this->all()));

        if ($this->has('subtotal')) {
            $this->merge(['subtotal' => floatval($this->subtotal)]);
        }
        if ($this->has('tax')) {
            $this->merge(['tax' => floatval($this->tax)]);
        }
        if ($this->has('total')) {
            $this->merge(['total' => floatval($this->total)]);
        }
        if ($this->has('discount')) {
            $this->merge(['discount' => floatval($this->discount)]);
        }
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'items.*.product_id' => 'product',
            'items.*.name' => 'product name',
            'items.*.price' => 'product price',
            'items.*.quantity' => 'quantity',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $calculatedTotal = $this->calculateTotal();
            if (abs($calculatedTotal - $this->total) > 0.01) {
                $validator->errors()->add('total', 'The total amount does not match the calculation of items.');
            }
        });
    }

    /**
     * Calculate the total from items
     *
     * @return float
     */
    private function calculateTotal(): float
    {
        $subtotal = 0;
        foreach ($this->items as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $tax = $subtotal * 0.14; // 14% tax
        $total = $subtotal + $tax - ($this->discount ?? 0);

        return round($total, get_setting('site_precision', 2) );
    }
}
