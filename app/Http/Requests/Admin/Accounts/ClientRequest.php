<?php

namespace App\Http\Requests\Admin\Accounts;

use Illuminate\{Foundation\Http\FormRequest};

class ClientRequest extends FormRequest
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
        $client = $this->route(param: 'client');

        $rules['name'] = ['required', 'string', 'max:255'];
        $rules['status'] = ['required', 'boolean'];
        $rules['email'] = [
            'required',
            'email',
            'regex:/(.+)@(.+)\.(.+)/i',
            'max:255',
            'unique:users,email,'.$client?->id.',id'
        ];
        $rules['phone'] = [
            'nullable',
            'numeric',
            'unique:users,phone,'.$client?->id.',id'
        ];
        if (!$client) {
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
