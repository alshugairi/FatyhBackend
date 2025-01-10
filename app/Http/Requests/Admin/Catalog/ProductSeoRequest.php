<?php

namespace App\Http\Requests\Admin\Catalog;

use Illuminate\{Foundation\Http\FormRequest};

class ProductSeoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string',
        ];
    }
}
