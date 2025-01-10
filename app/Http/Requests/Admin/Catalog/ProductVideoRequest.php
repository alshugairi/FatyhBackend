<?php

namespace App\Http\Requests\Admin\Catalog;

use Illuminate\{Foundation\Http\FormRequest};

class ProductVideoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'provider' => 'required|string|in:youtube,vimeo,dailymotion',
            'video_path' => 'required|url',
        ];
    }
}
