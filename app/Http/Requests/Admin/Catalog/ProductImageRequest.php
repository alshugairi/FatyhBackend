<?php

namespace App\Http\Requests\Admin\Catalog;

use Illuminate\{Foundation\Http\FormRequest};

class ProductImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'image_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
