<?php

namespace App\Http\Requests\Account;

use Illuminate\{Foundation\Http\FormRequest};

class AddressRequest extends FormRequest
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
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20', 'unique:addresses,phone,' . $this->route('address')?->id],
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'address_type' => ['required', 'in:billing,shipping'],
            'country_id' => ['required', 'exists:countries,id'],
            'city_id' => ['required', 'exists:cities,id'],
            'address_line_1' => ['required', 'string', 'max:255'],
            'address_line_2' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'is_default' => ['nullable', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_default' => $this->is_default ?? 0,
        ]);
    }
}
