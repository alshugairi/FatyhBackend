<?php

namespace App\Http\Requests\Frontend;

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
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email',
            'customer_notes' => 'nullable|string',

            'payment_method' => 'nullable|string|in:cash_on_delivery,stripe,paypal,myfatoorah,kashier,razorpay',

            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string',
            'shipping_country' => 'required|string',
            'shipping_postcode' => 'required|string',

            'billing_address' => 'nullable|string',
            'billing_city' => 'nullable|string',
            'billing_state' => 'nullable|string',
            'billing_country' => 'nullable|string',
            'billing_postcode' => 'nullable|string',
        ];
    }
}
