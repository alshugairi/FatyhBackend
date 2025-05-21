<?php

namespace App\Http\Requests\Admin\Auth;

use App\Enums\UserType;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\{Foundation\Http\FormRequest};

class RegisterIndividualRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'nickname' => ['required', 'string', 'max:255'],
            'email' => ['required','email', Rule::unique('users', 'email')],
            'phone' => ['required','numeric',Rule::unique('users', 'phone'),'regex:/^\+[0-9]+$/'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
            'type' => UserType::BUSINESS_OWNER->value,
            'status' => $this->status ?? 1,
        ]);
    }
}
