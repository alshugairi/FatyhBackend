<?php

namespace App\Http\Requests\Admin\Sales;

use Illuminate\{Foundation\Http\FormRequest};

class CouponRequest extends FormRequest
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
        $coupon = $this->route('coupon');

        return [
            'name' => ['required', 'array'],
            'name.*' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'array'],
            'description.*' => ['nullable', 'string', 'max:255'],
            'code' => 'required|string|unique:coupons,code,' . $coupon?->id,
            'type' => 'required|string|in:percentage,fixed_amount',
            'value' => 'required|numeric|min:0',
            'limit_per_user' => 'nullable|integer|min:1',
            'max_usage' => 'nullable|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }
}
