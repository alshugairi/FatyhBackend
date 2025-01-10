<?php

namespace App\Http\Requests\Admin\Settings;

use Illuminate\{Foundation\Http\FormRequest};

class CountryRequest extends FormRequest
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
        $country = $this->route('country');

        $rules['name'] = ['required', 'array'];
        $rules['name.*'] = ['required', 'string', 'max:255'];
        $rules['nationality'] = ['required', 'array'];
        $rules['nationality.*'] = ['required', 'string', 'max:255'];
//        $rules['iso2'] = ['required', 'string', 'max:255', 'unique:countries,iso2,' . $country?->id];
//        $rules['iso3'] = ['required', 'string', 'max:255', 'unique:countries,iso3,' . $country?->id];
//        $rules['dial_code'] = ['nullable'];
//        $rules['flag_emoji'] = ['nullable'];
        $rules['currency_id'] = ['required','integer', 'exists:currencies,id'];
        $rules['timezone'] = ['required','string'];
        return $rules;
    }
}
