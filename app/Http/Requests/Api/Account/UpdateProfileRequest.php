<?php

namespace App\Http\Requests\Api\Account;

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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'gender'     => ['required', 'string', 'in:male,female'],
            'birthdate'  => ['required', 'date'],
            'phone'      => ['required', 'string', 'max:255'],
            //'email'      => ['required','email','regex:/(.+)@(.+)\.(.+)/i','max:255','unique:users,email,'.auth()->id().',id']
        ];
    }
}
