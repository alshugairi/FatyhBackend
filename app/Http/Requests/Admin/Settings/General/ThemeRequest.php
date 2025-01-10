<?php

namespace App\Http\Requests\Admin\Settings\General;

use Illuminate\{Foundation\Http\FormRequest};

class ThemeRequest extends FormRequest
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
            'theme_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'theme_favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'theme_light_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
