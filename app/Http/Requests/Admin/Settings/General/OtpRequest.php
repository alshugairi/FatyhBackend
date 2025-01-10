<?php

namespace App\Http\Requests\Admin\Settings\General;

use Illuminate\{Foundation\Http\FormRequest};

class OtpRequest extends FormRequest
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
            'otp_type' => 'required|string|in:both,sms,email',
            'otp_digit_limit' => 'required|integer|in:6,8,10',
            'otp_expire_time' => 'required|integer|in:5,10,15,20,30,60',
        ];
    }
}
