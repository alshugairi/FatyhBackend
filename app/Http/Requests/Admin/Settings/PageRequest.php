<?php

namespace App\Http\Requests\Admin\Settings;

use Illuminate\{Foundation\Http\FormRequest, Validation\Rule};

class PageRequest extends FormRequest
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
        $rules['content'] = ['nullable', 'array'];
        $rules['content.*'] = ['nullable', 'string'];

        $rules['slug'] = [
            'required',
            'string',
            'max:255',
            'regex:/^[\p{Arabic}a-z0-9-]+$/u',
            Rule::unique('posts', 'slug')->ignore($this->page)
        ];
        return $rules;
    }
}
