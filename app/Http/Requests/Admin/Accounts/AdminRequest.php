<?php

namespace App\Http\Requests\Admin\Accounts;

use Illuminate\{Foundation\Http\FormRequest};

class AdminRequest extends FormRequest
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
        $admin = $this->route(param: 'admin');

        $rules['name'] = ['required', 'string', 'max:255'];
        $rules['status'] = ['required', 'boolean'];
        $rules['email'] = [
            'required',
            'email',
            'regex:/(.+)@(.+)\.(.+)/i',
            'max:255',
            'unique:users,email,'.$admin?->id.',id'
        ];
        $rules['phone'] = [
            'nullable',
            'numeric',
            'unique:users,phone,'.$admin?->id.',id'
        ];
        $rules['role'] = ['required', 'string', "exists:roles,name"];

        if (!$admin) {
            $rules['password'] = ['required', 'string', 'min:8', 'same:password-confirmation'];
        } else {
            $rules['password'] = ['nullable', 'string', 'min:8', 'same:password-confirmation'];
        }
        return $rules;
    }

    /**
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'status' => $this->status ?? 0,
        ]);
    }
}
