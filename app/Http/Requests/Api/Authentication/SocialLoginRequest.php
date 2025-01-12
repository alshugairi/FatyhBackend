<?php

namespace App\Http\Requests\Api\Authentication;

use Illuminate\{Foundation\Http\FormRequest};

class SocialLoginRequest extends FormRequest
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
            'provider' => ['required', 'string'],
            'provider_id' => ['required', 'string'],
        ];
    }
}
