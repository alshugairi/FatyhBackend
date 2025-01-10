<?php

namespace App\Http\Requests\Admin\Settings;

use Illuminate\{Foundation\Http\FormRequest};

class CityRequest extends FormRequest
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
        $rules['name'] = ['required', 'array'];
        $rules['name.*'] = ['required', 'string', 'max:255'];
        $rules['country_id'] = ['nullable', 'integer', 'exists:countries,id'];
        return $rules;
    }
}
