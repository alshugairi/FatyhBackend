<?php

namespace App\Http\Requests\Admin\Settings;

use Illuminate\{Foundation\Http\FormRequest};

class LanguageRequest extends FormRequest
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
        $language = $this->route('language');

        $rules['name'] = ['required', 'string', 'max:255', 'unique:languages,name,' . $language?->id];
        $rules['code'] = ['required', 'string', 'max:255', 'unique:languages,code,' . $language?->id];
        return $rules;
    }
}
