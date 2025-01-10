<?php

namespace App\Http\Requests\Admin\Catalog;

use Illuminate\{Foundation\Http\FormRequest};

class UnitRequest extends FormRequest
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
        $unit = $this->route('unit');

        return [
            'name' => ['required', 'array'],
            'name.*' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255', 'unique:units,code,' . $unit?->id],
            'description' => ['nullable', 'array'],
            'description.*' => ['nullable', 'string', 'max:255'],
            'status' => ['sometimes', 'boolean'],
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
