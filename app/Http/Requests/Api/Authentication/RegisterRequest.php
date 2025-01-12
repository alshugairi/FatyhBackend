<?php

namespace App\Http\Requests\Api\Authentication;

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
        $user = User::where('phone', $this->phone)->where('verified', false)->first();

        return [
            'email' => [
                'nullable',
                'email',
                Rule::unique('users', 'email')->ignore($user?->id),
            ],
            'phone' => [
                'required',
                'numeric',
                Rule::unique('users', 'phone')->ignore($user?->id),
                'regex:/^\+[0-9]+$/',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                //'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]+$/'
            ],
            'fcm_token' => ['nullable'],
            'first_name' => ['required', 'string'],
            'status' => ['required', 'integer'],
        ];
    }

    public function messages(): array
    {
        return [
            'username.unique' => __('validation.unique_phone_or_username'),
            'username.regex' => __('validation.username_regex'),
            'phone.regex' => __('validation.phone_regex'),
            'password.regex' => __('validation.password_complex'),
        ];
    }

    /**
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'status' => $this->status ?? 1,
            'first_name' => $this->username
        ]);
    }
}
