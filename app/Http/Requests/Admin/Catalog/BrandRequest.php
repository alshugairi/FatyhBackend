<?php

namespace App\Http\Requests\Admin\Catalog;

use Illuminate\{Foundation\Http\FormRequest};

class BrandRequest extends FormRequest
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
            'name' => ['required', 'array'],
            'name.*' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'array'],
            'description.*' => ['nullable', 'string', 'max:255'],
            'status' => ['sometimes', 'boolean'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }

    /**
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'status' => $this->boolean('status', false),
        ]);
    }
}
