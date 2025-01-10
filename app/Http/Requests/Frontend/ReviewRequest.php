<?php

namespace App\Http\Requests\Frontend;

use Illuminate\{Foundation\Http\FormRequest};

class ReviewRequest extends FormRequest
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
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|between:1,5',
            'review' => 'nullable|string|max:1000',
        ];
    }
}
