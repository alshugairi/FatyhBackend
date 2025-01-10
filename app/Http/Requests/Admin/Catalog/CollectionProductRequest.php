<?php

namespace App\Http\Requests\Admin\Catalog;

use Illuminate\{Foundation\Http\FormRequest,Validation\Rule};

class CollectionProductRequest extends FormRequest
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
            'product_id' => [
                'required',
                'exists:products,id',
                Rule::unique('collection_products')
                    ->where('collection_id', $this->route('collection')->id)
                    ->where('product_id', $this->product_id)
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.unique' => __('validation.product_already_in_collection'),
        ];
    }
}
