<?php

namespace App\Http\Requests\Api\Authentication;

use Illuminate\{Foundation\Http\FormRequest};

class CheckUserNameRequest extends FormRequest
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
            'username' => 'required|string|min:3|max:50'
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => __('validation.phone_regex'),
            'password.regex' => __('validation.password_complex'),
        ];
    }
}
