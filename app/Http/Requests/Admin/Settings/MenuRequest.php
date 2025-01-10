<?php

namespace App\Http\Requests\Admin\Settings;

use Illuminate\{Foundation\Http\FormRequest};

class MenuRequest extends FormRequest
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
            'name' => 'required|array',
            'name.*' => 'required|string',
            'menu_items_structure' => 'nullable|json',
            'status' => ['sometimes', 'boolean'],
            'position' => ['nullable', 'string', 'in:primary,footer,topbar'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'status' => $this->boolean('status', false),
        ]);
    }
}
