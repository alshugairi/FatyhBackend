<?php

namespace App\Http\Requests\Admin\Inventory;

use Illuminate\{Foundation\Http\FormRequest};

class SupplierRequest extends FormRequest
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
            'name.*' => 'required|string|max:255',
            'company_name' => 'nullable|array',
            'company_name.*' => 'nullable|string|max:255',
            'address' => 'nullable|array',
            'address.*' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:15',
            'postal_code' => 'nullable|string|max:10',
            'tax_id' => 'nullable|string|max:20',
            'status' => 'required|boolean',
            'image' => 'nullable|image|max:2048',
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
