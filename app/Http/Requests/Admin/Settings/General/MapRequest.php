<?php

namespace App\Http\Requests\Admin\Settings\General;

use Illuminate\{Foundation\Http\FormRequest};

class MapRequest extends FormRequest
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
            'map_longitude' => 'nullable|numeric|between:-180,180',
            'map_latitude' => 'nullable|numeric|between:-90,90',
            'map_google_map_key' => 'nullable|string|max:255',
            'map_address' => 'nullable|string|max:255',
            'map_visible' => 'required|boolean',
        ];
    }
}
