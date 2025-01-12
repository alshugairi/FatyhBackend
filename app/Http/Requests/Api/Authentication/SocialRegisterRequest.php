<?php

namespace App\Http\Requests\Api\Authentication;

use App\Rules\NoEmailOrPhone;
use Illuminate\{Foundation\Http\FormRequest};

class SocialRegisterRequest extends FormRequest
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
            'provider' => ['required','string'],
            'provider_id' => ['nullable', 'unique:users,provider_id'],
            'name' => ['nullable','string'],
            'email' => ['nullable', 'email', 'unique:users,email'],
            'avatar' => ['nullable','string'],
            'fcm_token' => ['nullable'],
            'status' => ['required', 'integer'],
        ];
    }


    /**
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'status' => 1,
        ]);
    }
}
