<?php
namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'billing_address' => 'required|array',
            'billing_address.first_name' => 'required|string|max:255',
            'billing_address.last_name' => 'required|string|max:255',
            'billing_address.email' => 'required|email|max:255',
            'billing_address.phone' => 'required|string|max:20',
            'billing_address.country' => 'required|string|max:100',
            'billing_address.city' => 'required|string|max:100',
            'billing_address.zip_code' => 'required|string|max:20',
            'payment_method' => 'required|string|in:cod,stripe',

            'customer_name' => 'nullable|string',
            'customer_email' => 'nullable|email',
            'customer_phone' => 'nullable|string',
            'billing_country' => 'nullable|string',
            'billing_city' => 'nullable|string',
            'billing_postcode' => 'nullable|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'billing_address.first_name' => 'first name',
            'billing_address.last_name' => 'last name',
            'billing_address.email' => 'email',
            'billing_address.phone' => 'phone',
            'billing_address.country' => 'country',
            'billing_address.city' => 'city',
            'billing_address.zip_code' => 'zip code',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'customer_name' => $this->input('billing_address.first_name') . ' ' . $this->input('billing_address.last_name'),
            'customer_email' => $this->input('billing_address.email'),
            'customer_phone' => $this->input('billing_address.phone'),
            'billing_country' => $this->input('billing_address.country'),
            'billing_city' => $this->input('billing_address.city'),
            'billing_postcode' => $this->input('billing_address.zip_code'),
        ]);
    }
}
