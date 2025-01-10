<?php

namespace App\Http\Requests\Admin\Settings\General;

use Illuminate\{Foundation\Http\FormRequest};

class PaymentGatewayRequest extends FormRequest
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
            'payment_paypal_app_id' => 'nullable|max:255',
            'payment_paypal_client_id' => 'nullable|max:255',
            'payment_paypal_client_secret' => 'nullable|max:255',
            'payment_stripe_key' => 'nullable|max:255',
            'payment_stripe_secret' => 'nullable|max:255',
        ];
    }
}
