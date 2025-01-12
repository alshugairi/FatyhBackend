<?php

namespace App\Http\Requests\Api\Authentication;

use Illuminate\{Foundation\Http\FormRequest};

class ResendOTPRequest extends FormRequest
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
            'phone' => ['required','regex:/^(\+\d{1,3})?[0-9]{7,14}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => __('validation.phone_invalid'),
        ];
    }
}
