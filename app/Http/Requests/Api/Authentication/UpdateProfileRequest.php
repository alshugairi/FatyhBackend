<?php

namespace App\Http\Requests\Api\Authentication;

use App\Rules\NoEmailOrPhone;
use Illuminate\{Foundation\Http\FormRequest};

class UpdateProfileRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:50', 'regex:/^[\p{Arabic}a-zA-Z]+$/u', new NoEmailOrPhone],
            'last_name' => ['required', 'string', 'max:50', 'regex:/^[\p{Arabic}a-zA-Z]+$/u', new NoEmailOrPhone],
            'gender' => ['required', 'string', 'in:male,female'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'], // Max size is 1MB
            'longitude' => ['nullable', 'numeric'],
            'latitude' => ['nullable', 'numeric'],
            'description' => ['nullable', 'string'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['integer', 'exists:categories,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.regex' => __('validation.letters_only'),
            'last_name.regex' => __('validation.letters_only'),
        ];
    }
}
