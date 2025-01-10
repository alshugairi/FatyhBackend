<?php

namespace App\Http\Requests\Admin\Settings\General;

use Illuminate\{Foundation\Http\FormRequest};

class SmsGatewayRequest extends FormRequest
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
            'sms_twilio_account_sid' => 'nullable|max:255',
            'sms_twilio_auth_token' => 'nullable|max:255',
            'sms_twilio_from' => 'nullable|max:255',
            'sms_victorylink_username' => 'nullable|max:255',
            'sms_victorylink_password' => 'nullable|max:255',
        ];
    }
}
