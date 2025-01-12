<?php

namespace App\Http\Requests\Api\Authentication;

use Illuminate\{Foundation\Http\FormRequest};

class ChangePasswordRequest extends FormRequest
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
            'current_password' => 'required|string|current_password',
            'password' => 'required|confirmed|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/',
        ];
    }

    public function messages(): array
    {
        return [
            'password.regex' => __('validation.password_complex'),
        ];
    }
}
