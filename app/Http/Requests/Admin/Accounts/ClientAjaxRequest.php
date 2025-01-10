<?php

namespace App\Http\Requests\Admin\Accounts;

use Illuminate\{Foundation\Http\FormRequest};

class ClientAjaxRequest extends FormRequest
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
        $rules['email'] = ['nullable','email','unique:users,email,'.$client?->id.',email'];
        $rules['phone'] = ['nullable','numeric','unique:users,phone,'.$client?->id.',id'];
        return $rules;
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
