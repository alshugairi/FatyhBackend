<?php

namespace App\Http\Requests\Api\Authentication;

use App\Enums\UserType;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\{Foundation\Http\FormRequest};

class RegisterRequest extends FormRequest
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
            'account_type' => ['required','string','in:individual,company'],
            'name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'nickname' => ['required', 'string', 'max:255'],
            'email' => ['required','email', Rule::unique('users', 'email')],
            'phone' => [
                'required',
                'numeric',
                Rule::unique('users', 'phone'),
                'regex:/^\+[0-9]+$/',
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'country_id' => ['required', 'exists:countries,id'],
            'city_id' => ['required', 'exists:cities,id'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'], // Max size is 1MB
            'fcm_token' => ['nullable'],
            'status' => ['required', 'integer'],
            'type' => ['required', 'integer'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => __('validation.phone_invalid'),
            'password.regex' => __('validation.password_complex'),
        ];
    }

    /**
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'type' => $this->account_type === 'individual' ? UserType::CLIENT->value : UserType::BUSINESS_OWNER->value,
            'status' => $this->status ?? 1,
            'name' => $this->first_name. ' ' .(!empty($this->middle_name) ? $this->middle_name . ' ' : '').$this->last_name
        ]);
    }
}
